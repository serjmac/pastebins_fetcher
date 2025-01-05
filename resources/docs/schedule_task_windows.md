To schedule the `php artisan fetch:pastebins` command to run every hour on a Windows machine, you can use the Task Scheduler. Here are the steps to set it up:

1. **Open Task Scheduler**:
   - Press `Win + R` to open the Run dialog.
   - Type `taskschd.msc` and press Enter to open Task Scheduler.

2. **Create a New Task**:
   - In the Task Scheduler, click on `Create Task` in the right-hand Actions pane.

3. **General Settings**:
   - In the General tab, provide a name for the task, e.g., "Laravel Fetch Pastebins".
   - Optionally, provide a description.
   - Choose "Run whether user is logged on or not" if you want the task to run even when you're not logged in.

4. **Trigger Settings**:
   - Go to the Triggers tab and click `New`.
   - Set the task to begin "On a schedule".
   - Set the schedule to "Daily" and repeat the task every 1 hour.
   - Click `OK`.

5. **Action Settings**:
   - Go to the Actions tab and click `New`.
   - Set the action to "Start a program".
   - In the "Program/script" field, enter the path to your PHP executable, e.g., `C:\path\to\php.exe`.
   - In the "Add arguments (optional)" field, enter the artisan command:
     ```bash
     artisan fetch:pastebins
     ```
   - In the "Start in (optional)" field, enter the path to your Laravel project directory, e.g., `C:\Users\Serj\Documents\dev\pastebin-checker\laravel-pastebin-checker2`.
   - Click `OK`.

6. **Conditions and Settings**:
   - Optionally, configure any conditions or settings as needed in the Conditions and Settings tabs.

7. **Save the Task**:
   - Click `OK` to save the task.
   - If prompted, enter your Windows user account password.

This will schedule the `php artisan fetch:pastebins` command to run every hour using Task Scheduler on Windows.