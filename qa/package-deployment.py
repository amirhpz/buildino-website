"""Package the separately installed production tree; exclude local configuration and caches."""
from pathlib import Path
from zipfile import ZipFile, ZIP_DEFLATED
import hashlib, json

root = Path(__file__).resolve().parent.parent
stage = root / "qa" / "deployment"
assert (stage / "vendor" / "autoload.php").is_file(), "Prepare production vendor first"
output = root / "qa" / "buildino-shared-host.zip"
allowed = {"app", "bootstrap", "config", "database", "resources", "routes", "public", "storage", "vendor"}
root_files = {"artisan", "composer.json", "composer.lock", "README.md", ".env.production.example"}
with ZipFile(output, "w", ZIP_DEFLATED, compresslevel=6) as archive:
    for source in sorted(stage.rglob("*")):
        if not source.is_file():
            continue
        relative = source.relative_to(stage)
        if relative.parts[0] not in allowed and relative.as_posix() not in root_files:
            continue
        if source.name in {".env", "hot"} or source.suffix in {".log", ".sqlite", ".sqlite3", ".db"}:
            continue
        if relative.parts[0] == "storage" and source.name != ".gitignore":
            continue
        if relative.parts[:2] == ("bootstrap", "cache") and source.name != ".gitignore":
            continue
        archive.write(source, relative.as_posix())
with ZipFile(output) as archive:
    names = archive.namelist()
    assert ".env" not in names
    assert "vendor/autoload.php" in names
    assert "public/build/manifest.json" in names
    assert "bootstrap/cache/config.php" not in names
manifest = {"file": output.name, "bytes": output.stat().st_size, "files": len(names), "sha256": hashlib.sha256(output.read_bytes()).hexdigest(), "vendor": "composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader", "excludes": ["real .env", "local caches", "logs", "databases", "Node dependencies"]}
(root / "qa" / "deployment-package.json").write_text(json.dumps(manifest, indent=2) + "\n", encoding="utf-8")
print(json.dumps(manifest))
