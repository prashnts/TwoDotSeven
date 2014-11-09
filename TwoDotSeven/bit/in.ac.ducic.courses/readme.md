How to Install
==============

Since the frontend for installing bits is not ready, yet, we're going to install it manually.

Step 1. Unzip the bit in bits directory. This is already done, if you're using ``$ git pull``.

Step 2. Open `index.php` in directory TwoDotSeven. Paste this line of code before comment: `# Parse incoming URI and then process it.`.

    var_dump(\\TwoDot7\\Bit\\Register::Install("in.ac.ducic.courses")); die();

Step 3. Visit the web app once to execute this code.

Step 4. Installation is done. Revert the `index.php` back to the way it was, by deleting the code.