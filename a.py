import os

text = []
file_count = 0
folder_count = 0
total_size = 0

# پوشه‌هایی که باید نادیده گرفته شوند
exclude = {'vendor', 'node_modules', '.git', '__pycache__'}

for root, dirs, files in os.walk("."):
    # فیلتر کردن پوشه‌ها (با نادیده گرفتن حروف بزرگ/کوچک)
    dirs[:] = [d for d in dirs if d.lower() not in exclude]

    folder_count += len(dirs)

    for file in files:
        file_path = os.path.join(root, file)
        file_count += 1
        total_size += os.path.getsize(file_path)
        try:
            with open(file_path, "r", encoding="utf-8") as f:
                text.append(f.read())
        except (UnicodeDecodeError, OSError):
            text.append(f"[خطا در خواندن {file_path}]")

print("file_count:", file_count)
print("folder_count:", folder_count)
print("total_size:", total_size, "bytes")

with open("report.txt", "w", encoding="utf-8") as f:
    for line in text:
        f.write(line + "\n" + "="*40 + "\n")