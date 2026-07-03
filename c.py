import subprocess
import sys
from datetime import datetime


def run(command):
    print(f"\n> {command}")
    result = subprocess.run(command, shell=True)
    if result.returncode != 0:
        print("\nCommand failed.")
        sys.exit(result.returncode)


def main():
    if len(sys.argv) > 1:
        message = " ".join(sys.argv[1:])
    else:
        message = input("Commit message: ").strip()

    if not message:
        message = f"Update {datetime.now():%Y-%m-%d %H:%M:%S}"

    run("git add .")
    run(f'git commit -m "{message}"')
    run("git push")

    print("\n✓ Done!")


if __name__ == "__main__":
    main()