from pathlib import Path

ROOT = Path(".")
OUTPUT = ROOT / "all-code.txt"

allowed_extensions = {
    ".php",
    ".html",
    ".json",
}

excluded_dirs = {
    "vendor",
    ".git",
}

excluded_files = {
    "all-code.txt",
    "view-code.txt",
    "a.py",
    "composer.lock",
    "composer.phar",
}

files = []

for path in ROOT.rglob("*"):
    if not path.is_file():
        continue

    if any(part in excluded_dirs for part in path.parts):
        continue

    if path.name in excluded_files:
        continue

    if path.suffix.lower() not in allowed_extensions:
        continue

    files.append(path)

files.sort()

with OUTPUT.open("w", encoding="utf-8") as f:
    for path in files:
        f.write(f"\n===== FILE: {path} =====\n\n")
        try:
            f.write(path.read_text(encoding="utf-8"))
        except UnicodeDecodeError:
            f.write("[Could not read file as UTF-8]\n")

print(f"Done. {len(files)} files written to {OUTPUT}")