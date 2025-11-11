#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Laravel view counter tool
-------------------------
Usage:
    python3 count_views.py

Place this file in the root directory of your Laravel project.
It recursively searches for view returns (return view(...)),
Inertia::render(...), Livewire::class, etc. in app/ directory.

Outputs:
- Total count of screens (unique view names)
- Detailed list of found views with file paths and line numbers
"""

import os
import re
from typing import List, Dict

TARGET_DIR = "app"  # Laravel controllers and related logic

# Patterns to capture
PATTERNS = {
    "laravel_view": re.compile(r"return\s+view\s*\(\s*['\"]([^'\"]+)['\"]"),
    "inertia": re.compile(r"Inertia::render\s*\(\s*['\"]([^'\"]+)['\"]"),
    "livewire": re.compile(r"Livewire::class|<livewire:"),
}

def scan_file(filepath: str) -> List[Dict[str, str]]:
    results = []
    with open(filepath, "r", encoding="utf-8", errors="ignore") as f:
        for idx, line in enumerate(f, start=1):
            for key, pattern in PATTERNS.items():
                match = pattern.search(line)
                if match:
                    results.append({
                        "file": filepath,
                        "line": idx,
                        "type": key,
                        "value": match.group(1) if match.groups() else "(component)",
                    })
    return results


# --- Route scanning (Route → Controller → Action) ---
def scan_routes() -> List[Dict[str, str]]:
    route_files = ["routes/web.php", "routes/admin.php", "routes/api.php"]
    route_pattern = re.compile(r"Route::(get|post|put|delete|patch)\\(\\s*['\"]([^'\"]+)['\"]\\s*,\\s*\\[(.*?)::class\\s*,\\s*['\"](.*?)['\"]")
    routes = []
    for file in route_files:
        if not os.path.exists(file):
            continue
        with open(file, "r", encoding="utf-8", errors="ignore") as f:
            for idx, line in enumerate(f, start=1):
                match = route_pattern.search(line)
                if match:
                    routes.append({
                        "method": match.group(1).upper(),
                        "path": match.group(2),
                        "controller": match.group(3),
                        "action": match.group(4),
                        "file": file,
                        "line": idx,
                    })
    return routes

# --- View scanning ---
def crawl() -> List[Dict[str, str]]:
    found = []

    for root, _, files in os.walk(TARGET_DIR):
        for file in files:
            if file.endswith(".php"):
                full_path = os.path.join(root, file)
                found.extend(scan_file(full_path))

    return found


def main():
    print("🔍 Laravel screen(view) counter tool")
    print(f"📂 Target directory: {TARGET_DIR}/")

    results = crawl()

    view_set = set([r["value"] for r in results if r["type"] == "laravel_view"])
    inertia_set = set([r["value"] for r in results if r["type"] == "inertia"])
    livewire_hits = [r for r in results if r["type"] == "livewire"]

    print("\n✅ 結果まとめ")
    print("---------------------------------")
    print(f"Blade views (return view):       {len(view_set)}")
    print(f"Inertia pages:                   {len(inertia_set)}")
    print(f"Livewire components (hit count): {len(livewire_hits)}")
    print(f"---------------------------------")
    print(f"📊 合計 画面数候補: {len(view_set) + len(inertia_set) + len(livewire_hits)}")
    print("---------------------------------\n")

    # Detailed output
    for r in results:
        print(f"[{r['type']}] {r['value']}  →  {r['file']}:{r['line']}")


if __name__ == "__main__":
    # --- Log setup: save output to text file in root directory ---
    import datetime, sys
    log_filename = f"view_count_log_{datetime.datetime.now().strftime('%Y%m%d_%H%M%S')}.txt"
    log = open(log_filename, "w", encoding="utf-8")

    class Tee:
        def __init__(self, *files):
            self.files = files
        def write(self, obj):
            for f in self.files:
                f.write(obj)
        def flush(self):
            for f in self.files:
                f.flush()

    sys.stdout = Tee(sys.stdout, log)
    # --- End logging setup ---
    main()
