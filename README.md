### Pamager Setup
*Pamager currently only supports devices with width less than 768px. Anything above that will cause style not being added.*

Download the source code from [HERE](http://https://github.com/ganeshbistakaji/Pamager/releases/ "HERE")

- After downloading make sure to unarchive the file.
- We need to install phpMailer library for mailing system (must install).
- Open Terminal inside of the root directory of Pamager and run
```bash
composer require phpmailer/phpmailer
```
If you do not have composer in your system make sure to install that globally or locally.

### Mailing System
Check the files for mailing requirements and enter your e-mail and app password in it.
![image](https://github.com/ganeshbistakaji/Pamager/assets/117885646/7236d73f-2b3c-4f0b-ad9a-efc77eb4e92a)


### Database System
- In db.php make sure to change database credentials as per your wish. Pamager uses MYSQL.
  ![image](https://github.com/ganeshbistakaji/Pamager/assets/117885646/ea264d2a-44cf-43b6-8c7d-708d719d9df3)

- After setting up database create a table named accounts with following information
```sql
CREATE TABLE accounts (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(5000) NOT NULL,
    type INT(10) NOT NULL,
    reset VARCHAR(10),
    theme VARCHAR(100),
    verify VARCHAR(10),
    status VARCHAR(20)
);

```

### Theme Setup
- In theme.php make sure to add the theme name same as the theme directory name in the array of themes.
- Move you theme folder in css/themes.
*The theme changing is managed through database directly.*

### To-Do
- Remember login
- Admin Panel
- Dark Mode
- Desktop View

### More
- Pull requests to improve the project are highly appreciated.
- Looking for a contributor to create an installation script.
- Removing any form of credits mentioned as  <!-- Credits --> isn't allowed.
- Pamager is protected under GNU General Public License v3.0.

### Credits
Developer: Ganesh Bista (deadbush, deadbushmc, ganeshbistakaji)
UI Designer: Ganesh Bista, Harshita Jitani
