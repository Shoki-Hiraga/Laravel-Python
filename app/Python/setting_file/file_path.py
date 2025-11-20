from setting_file import csv_output_path

# ファイルパス
file_directory_index = 5 # 使用するファイルパスのインデックス番号
file_Directorys = {
    1: csv_output_path.out_office,
    2: csv_output_path.out_main,
    3: csv_output_path.out_raytrek,
    4: csv_output_path.out_K39_sho,
    5: csv_output_path.out_root
}

file_directory = file_Directorys[file_directory_index]