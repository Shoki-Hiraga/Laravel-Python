#!/usr/bin/env python3
# -*- coding: utf-8 -*-

"""
Universal Web App Screen Crawler
--------------------------------
- 再帰的にディレクトリを走査
- 代表的な Web アプリケーションフレームワークを自動判定
- 各フレームワークごとに「画面候補」を抽出して一覧表示

対応（ベース実装。必要に応じて拡張可）:
- Laravel: return view(), Inertia::render(), Livewire, routes
- Nuxt: pages/**/*.vue
- Next.js: pages/**/*.(js|ts|jsx|tsx), app/**/page.(js|ts|jsx|tsx)
- Vue (SPA): src/views/*.vue, views/*.vue
- React: src/pages/*.(jsx|tsx|js|ts)
- 汎用: views/, templates/ 配下の .html / .blade.php など

使い方:
    python3 universal_screen_crawler.py

出力:
- 検出したフレームワーク
- 各フレームワークごとの画面候補数と一覧
"""

import os
import re
import json
import datetime
from typing import List, Dict, Any, Set


# -------------------------------
# 共通: ファイル収集
# -------------------------------

SKIP_DIRS = {
    ".git",
    "vendor",
    "node_modules",
    "storage",
    ".nuxt",
    ".next",
    "dist",
    "build",
    ".idea",
    ".vscode",
    "coverage",
    "tmp",
    "log",
    "logs",
    "__pycache__",
}


def collect_files(root: str = ".") -> List[str]:
    files: List[str] = []
    for dirpath, dirnames, filenames in os.walk(root):
        # 不要ディレクトリを prune
        dirnames[:] = [d for d in dirnames if d not in SKIP_DIRS]
        for f in filenames:
            files.append(os.path.join(dirpath, f))
    return files


# -------------------------------
# フレームワーク自動判定
# -------------------------------

def safe_read_json(path: str) -> Any:
    try:
        with open(path, "r", encoding="utf-8", errors="ignore") as f:
            return json.load(f)
    except Exception:
        return None


def safe_read_text(path: str, max_bytes: int = 20000) -> str:
    try:
        with open(path, "r", encoding="utf-8", errors="ignore") as f:
            data = f.read(max_bytes)
            return data
    except Exception:
        return ""


def detect_frameworks(files: List[str]) -> Set[str]:
    frameworks: Set[str] = set()

    for path in files:
        name = os.path.basename(path).lower()

        # Laravel
        if name == "composer.json":
            data = safe_read_json(path)
            if isinstance(data, dict):
                deps = {}
                deps.update(data.get("require", {}) or {})
                deps.update(data.get("require-dev", {}) or {})
                values = list(deps.keys()) + list(deps.values())
                if any("laravel/framework" in str(v) for v in values):
                    frameworks.add("laravel")

        # Node 系
        if name == "package.json":
            data = safe_read_json(path)
            if isinstance(data, dict):
                deps = {}
                deps.update(data.get("dependencies", {}) or {})
                deps.update(data.get("devDependencies", {}) or {})
                keys = set(map(str, deps.keys()))
                if any(k.startswith("nuxt") or "nuxt" == k for k in keys):
                    frameworks.add("nuxt")
                if "next" in keys:
                    frameworks.add("nextjs")
                if "react" in keys or "react-dom" in keys:
                    frameworks.add("react")
                if "vue" in keys or "@vue/runtime-core" in keys:
                    frameworks.add("vue")
                if "svelte" in keys:
                    frameworks.add("svelte")
                if "@angular/core" in keys:
                    frameworks.add("angular")
                if "astro" in keys:
                    frameworks.add("astro")

        # Rails
        if name == "gemfile":
            text = safe_read_text(path)
            if "rails" in text:
                frameworks.add("rails")

        # Django
        if name in ("manage.py", "settings.py"):
            text = safe_read_text(path)
            if "django" in text:
                frameworks.add("django")

        # Flask
        if name == "app.py":
            text = safe_read_text(path)
            if "flask" in text:
                frameworks.add("flask")

    return frameworks


# -------------------------------
# Laravel スキャン
# -------------------------------

LARAVEL_VIEW_RE = re.compile(r"return\s+view\s*\(\s*['\"]([^'\"]+)['\"]")
INERTIA_RE = re.compile(r"Inertia::render\s*\(\s*['\"]([^'\"]+)['\"]")
LIVEWIRE_RE = re.compile(r"Livewire::class|<livewire:")
ROUTE_RE = re.compile(
    r"Route::(get|post|put|delete|patch)\(\s*['\"]([^'\"]+)['\"]\s*,\s*\[(.*?)::class\s*,\s*['\"](.*?)['\"]"
)


def scan_laravel(files: List[str]) -> List[Dict[str, Any]]:
    hits: List[Dict[str, Any]] = []

    for path in files:
        if not path.endswith(".php"):
            continue
        # すでに vendor 等は除外済みの想定

        try:
            with open(path, "r", encoding="utf-8", errors="ignore") as f:
                for idx, line in enumerate(f, start=1):
                    m1 = LARAVEL_VIEW_RE.search(line)
                    if m1:
                        hits.append(
                            {
                                "type": "laravel_view",
                                "value": m1.group(1),
                                "file": path,
                                "line": idx,
                            }
                        )
                    m2 = INERTIA_RE.search(line)
                    if m2:
                        hits.append(
                            {
                                "type": "inertia",
                                "value": m2.group(1),
                                "file": path,
                                "line": idx,
                            }
                        )
                    m3 = LIVEWIRE_RE.search(line)
                    if m3:
                        hits.append(
                            {
                                "type": "livewire",
                                "value": "(component)",
                                "file": path,
                                "line": idx,
                            }
                        )
        except Exception:
            continue

    return hits


def scan_laravel_routes(files: List[str]) -> List[Dict[str, Any]]:
    routes: List[Dict[str, Any]] = []
    for path in files:
        # routes ディレクトリっぽいもの
        if not (
            "/routes/" in path.replace("\\", "/")
            and os.path.basename(path) in {"web.php", "api.php", "admin.php"}
        ):
            continue

        try:
            with open(path, "r", encoding="utf-8", errors="ignore") as f:
                for idx, line in enumerate(f, start=1):
                    m = ROUTE_RE.search(line)
                    if m:
                        routes.append(
                            {
                                "method": m.group(1).upper(),
                                "path": m.group(2),
                                "controller": m.group(3),
                                "action": m.group(4),
                                "file": path,
                                "line": idx,
                            }
                        )
        except Exception:
            continue

    return routes


# -------------------------------
# JS 系: 共通ユーティリティ
# -------------------------------

def norm(path: str) -> str:
    return path.replace("\\", "/")


def route_from_pages_path(path: str) -> str:
    """
    pages/users/[id].vue → /users/:id
    pages/index.vue      → /
    pages/blog/index.vue → /blog
    """
    p = norm(path)
    parts = p.split("/")

    if "pages" not in parts:
        return "(unknown)"

    idx = parts.index("pages")
    segments = parts[idx + 1 :]
    if not segments:
        return "/"

    # 最後の拡張子除去
    last = segments[-1]
    base = last.split(".")[0]
    segments[-1] = base

    # [id] → :id
    def conv(seg: str) -> str:
        return re.sub(r"\[(.+?)\]", r":\1", seg)

    segments = [conv(s) for s in segments]

    route = "/" + "/".join(s for s in segments if s)
    if route.endswith("/index"):
        route = route[: -len("/index")] or "/"
    return route or "/"


def route_from_next_app_path(path: str) -> str:
    """
    app/blog/[slug]/page.tsx → /blog/:slug
    """
    p = norm(path)
    parts = p.split("/")
    if "app" not in parts:
        return "(unknown)"
    idx = parts.index("app")
    segments = parts[idx + 1 :]
    if not segments:
        return "/"

    # 最後は page.tsx 想定なので除去
    if segments[-1].startswith("page."):
        segments = segments[:-1]

    def conv(seg: str) -> str:
        return re.sub(r"\[(.+?)\]", r":\1", seg)

    segments = [conv(s) for s in segments if s]
    if not segments:
        return "/"
    return "/" + "/".join(segments)


# -------------------------------
# Nuxt / Next / Vue / React スキャン
# -------------------------------

def scan_frontend_pages(files: List[str], frameworks: Set[str]) -> List[Dict[str, Any]]:
    hits: List[Dict[str, Any]] = []

    for path in files:
        n = norm(path)
        _, ext = os.path.splitext(n)
        ext = ext.lower()

        # Nuxt / Vue - pages/*.vue
        if ext == ".vue" and "/pages/" in n:
            route = route_from_pages_path(n)
            if "nuxt" in frameworks:
                ftype = "nuxt_page"
            elif "vue" in frameworks:
                ftype = "vue_page"
            else:
                ftype = "vue_like_page"
            hits.append({"type": ftype, "route": route, "file": path})

        # Vue SPA - src/views or views ディレクトリ
        if ext == ".vue" and (
            "/src/views/" in n or "/views/" in n
        ):
            view_name = os.path.splitext(os.path.basename(path))[0]
            hits.append(
                {
                    "type": "vue_view",
                    "route": f"(vue-view:{view_name})",
                    "file": path,
                }
            )

        # Next.js - pages ディレクトリ
        if ext in {".js", ".jsx", ".ts", ".tsx"} and "/pages/" in n:
            if "nextjs" in frameworks or "react" in frameworks:
                # Next.js または React + pages 構成
                route = route_from_pages_path(n)
                hits.append(
                    {
                        "type": "next_page",
                        "route": route,
                        "file": path,
                    }
                )

        # Next.js app router
        if (
            ext in {".js", ".jsx", ".ts", ".tsx"}
            and "/app/" in n
            and os.path.basename(n).startswith("page.")
        ):
            if "nextjs" in frameworks or "react" in frameworks:
                route = route_from_next_app_path(n)
                hits.append(
                    {
                        "type": "next_app_page",
                        "route": route,
                        "file": path,
                    }
                )

        # React SPA - src/pages
        if (
            ext in {".js", ".jsx", ".ts", ".tsx"}
            and "/src/pages/" in n
        ):
            page_name = os.path.splitext(os.path.basename(path))[0]
            hits.append(
                {
                    "type": "react_page",
                    "route": f"/{page_name}",
                    "file": path,
                }
            )

    return hits


# -------------------------------
# 汎用テンプレート検出
# -------------------------------

def scan_generic_templates(files: List[str]) -> List[Dict[str, Any]]:
    hits: List[Dict[str, Any]] = []
    for path in files:
        n = norm(path)
        base = os.path.basename(path)
        _, ext = os.path.splitext(base)
        ext = ext.lower()

        if not any(
            key in n
            for key in ("/views/", "/templates/", "/resources/views/")
        ):
            continue

        if ext in {".html", ".htm", ".blade.php", ".erb", ".twig"} or base.endswith(
            ".blade.php"
        ):
            hits.append(
                {
                    "type": "generic_template",
                    "name": base,
                    "file": path,
                }
            )
    return hits


# -------------------------------
# メイン処理
# -------------------------------

def main():
    print("🔍 Universal Web App Screen Crawler")
    print("📂 Scanning project tree...\n")

    all_files = collect_files(".")
    print(f"Total files scanned (excluding common vendor dirs): {len(all_files)}")

    frameworks = detect_frameworks(all_files)
    if frameworks:
        print("\n✅ Detected frameworks:")
        for fw in sorted(frameworks):
            print(f"  - {fw}")
    else:
        print("\n⚠️  No specific framework detected. Falling back to generic scan only.")

    # Laravel
    laravel_hits: List[Dict[str, Any]] = []
    laravel_routes: List[Dict[str, Any]] = []
    if "laravel" in frameworks:
        print("\n🔎 Scanning Laravel code...")
        laravel_hits = scan_laravel(all_files)
        laravel_routes = scan_laravel_routes(all_files)

    # Frontend frameworks
    print("\n🔎 Scanning frontend frameworks (Nuxt / Next / Vue / React)...")
    frontend_hits = scan_frontend_pages(all_files, frameworks)

    # Generic templates
    print("\n🔎 Scanning generic templates...")
    generic_hits = scan_generic_templates(all_files)

    # 集計
    blade_set = {h["value"] for h in laravel_hits if h["type"] == "laravel_view"}
    inertia_set = {h["value"] for h in laravel_hits if h["type"] == "inertia"}
    livewire_list = [h for h in laravel_hits if h["type"] == "livewire"]

    nuxt_pages = [h for h in frontend_hits if h["type"] == "nuxt_page"]
    vue_pages = [h for h in frontend_hits if h["type"] == "vue_page"]
    vue_views = [h for h in frontend_hits if h["type"] == "vue_view"]
    next_pages = [h for h in frontend_hits if h["type"] in ("next_page", "next_app_page")]
    react_pages = [h for h in frontend_hits if h["type"] == "react_page"]
    vue_like_pages = [h for h in frontend_hits if h["type"] == "vue_like_page"]

    # 画面候補総数（かなりざっくりだが、「画面っぽいもの」のユニーク数）
    total_candidates = (
        len(blade_set)
        + len(inertia_set)
        + len(livewire_list)
        + len(nuxt_pages)
        + len(vue_pages)
        + len(vue_views)
        + len(next_pages)
        + len(react_pages)
        + len(vue_like_pages)
        + len(generic_hits)
    )

    print("\n==============================")
    print("📊 Summary")
    print("==============================")
    if "laravel" in frameworks:
        print(f"Laravel Blade views:        {len(blade_set)}")
        print(f"Laravel Inertia pages:      {len(inertia_set)}")
        print(f"Laravel Livewire components:{len(livewire_list)}")
        print(f"Laravel routes:             {len(laravel_routes)}")
    print(f"Nuxt pages (pages/*.vue):   {len(nuxt_pages)}")
    print(f"Vue pages (pages/*.vue):    {len(vue_pages)}")
    print(f"Vue views (views/*.vue):    {len(vue_views)}")
    print(f"Next.js pages:              {len(next_pages)}")
    print(f"React pages (src/pages):    {len(react_pages)}")
    print(f"Other pages (vue_like):     {len(vue_like_pages)}")
    print(f"Generic templates:          {len(generic_hits)}")
    print("------------------------------")
    print(f"📘 合計 画面候補 (rough): {total_candidates}")
    print("==============================\n")

    # 詳細出力
    if laravel_hits:
        print("\n---- Laravel view-related hits ----")
        for h in laravel_hits:
            print(f"[{h['type']}] {h['value']} → {h['file']}:{h['line']}")

    if laravel_routes:
        print("\n---- Laravel routes ----")
        for rt in laravel_routes:
            print(
                f"[ROUTE] {rt['method']} {rt['path']} → "
                f"{rt['controller']}@{rt['action']} ({rt['file']}:{rt['line']})"
            )

    if frontend_hits:
        print("\n---- Frontend pages (Nuxt / Next / Vue / React) ----")
        for h in frontend_hits:
            print(f"[{h['type']}] {h.get('route', '')} → {h['file']}")

    if generic_hits:
        print("\n---- Generic templates ----")
        for h in generic_hits:
            print(f"[{h['type']}] {h['name']} → {h['file']}")


if __name__ == "__main__":
    # ログファイルに tee 出力
    log_filename = f"screen_crawler_log_{datetime.datetime.now().strftime('%Y%m%d_%H%M%S')}.txt"
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

    import sys

    sys.stdout = Tee(sys.stdout, log)
    main()
