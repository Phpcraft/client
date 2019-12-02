# Phpcraft Client

A Minecraft: Java Edition Client based on Phpcraft.

## Prerequisites

You'll need PHP, Composer, and Git.

### Instructions

- **Debian**: `apt-get -y install php-cli composer git`
- **Windows**:
  1. Install [Cone](https://getcone.org), which will install the latest PHP with it.
  2. Run `cone get composer` as administrator.
  3. Install [Git for Windows](https://git-scm.com/download/win).

## Setup

First, we'll clone the repository and generate the autoload script:

```Bash
git clone https://github.com/Phpcraft/client "Phpcraft Client"
cd "Phpcraft Client"
composer install --no-suggest --ignore-platform-reqs
```

Next, we'll run a self check:

```Bash
php vendor/craft/core/selfcheck.php
```

If any dependencies are missing, follow the instructions, and then run the self check again.

## Updating

To update the Phpcraft Client and its dependencies:

```Bash
git stash
git pull
composer update --no-dev --no-suggest --ignore-platform-reqs
git stash pop
``` 

If you have made local changes, they will be saved and re-applied after the update.

### That's it!

Now that you've got the Phpcraft Client all set up, you can start it:

```Bash
php client.php
```

It also has built-in commands; type `.help` in it for more information.
