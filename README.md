<a name="readme-top"></a>

<br />
<div align="center">
  <h1 align="center">PorcusorulMagic</h1>
  <h3 align="center">K4-System Time Played Website</h3>

  <p align="center">
    A website for K4-System Time Played addon by K4ryuu
    <br />
    <br />
    <a href="https://github.com/PorcusorulMagic/K4-System-Time-Played-Website/releases">Download</a>
    ·
    <a href="https://github.com/PorcusorulMagic/K4-System-Time-Played-Website/issues/new?assignees=K4ryuu&labels=bug&projects=&template=bug_report.md&title=%5BBUG%5D">Report Bug</a>
    ·
    <a href="https://github.com/PorcusorulMagic/K4-System-Time-Played-Website/issues/new?assignees=K4ryuu&labels=enhancement&projects=&template=feature_request.md&title=%5BREQ%5D">Request Feature</a>
  </p>
</div>

<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#dependencies">Dependencies</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#screenshot">Screenshot</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
  </ol>
</details>

## About The Project

This is a website to show players the time played on the server.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

### Dependencies

To use this website panel, you'll need the following dependencies installed:

- [**CounterStrikeSharp**](https://github.com/roflmuffin/CounterStrikeSharp/releases): CounterStrikeSharp allows you to write server plugins in C# for Counter-Strike 2/Source2/CS2
- **MySQL Database (Version 5.2 or higher):** This project requires a MySQL database to store and manage data. You can host your own MySQL server or use a third-party hosting service. Make sure it's at least version 5.2 or higher.
- [**K4-System**](https://github.com/K4ryuu/K4-System/releases): Without this addon, the website is useless.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- GETTING STARTED -->

## Getting Started

Follow these steps to install and use the webspace:

### Prerequisites

Before you begin, ensure you have the following prerequisites:

- A working CS2 (Counter-Strike 2) server.
- A working Website.
- CounterStrikeSharp is up to date and is running on your server.
- A compatible MySQL database (Version 5.2 or higher) set up and configured.
- K4-System loaded in your server.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

### Installation

1. **Download the Webspace:** Start by downloading the website from the [GitHub Releases Page](https://github.com/PorcusorulMagic/K4-System-Time-Played/releases). Choose the latest release version.

2. **Extract the Webspace:** After downloading, extract the contents of the website into your webhost directory. From the releases, you find it pre zipped with the correct name.

3. **Configuration:**

- Use mysql from your counterstrikesharp/configs/plugins/K4-System/K4-System.json
- Move conent of webserver/ folder to your webspace
- Edit inc/config.php
<details>
  <summary>Details here</summary><?php 
// Basic Settings -----------------------------------------------------------


// Set your site title
$siteTitle = "MyPanel";

// Set your site logo - "" blank for no background image
$siteLogo = "img/csgo.jpg";

// Set your background image - "" blank for no background image
$background = "img/background.jpg"; 

// Users per page
$usersPerPage = "20";

// Minimum total time a players needs to get in list
$mostactive_minSec = "10";


// Set bootstrap theme - remove // infront of a theme and add // to remove old

         $stylesheet = "css/bootsteam.css"; // https://github.com/StrutTower/bootsteam-theme

//         $stylesheet = "css/bootstrap.css"; // http://getbootstrap.com/
//         $stylesheet = "css/superhero.css"; // https://bootswatch.com/superhero/#tables
//         $stylesheet = "css/cosmo.css"; // https://bootswatch.com/cosmo/#tables
//         $stylesheet = "css/cerulean.css"; // https://bootswatch.com/cerulean/#tables
//         $stylesheet = "css/sandstone.css"; // https://bootswatch.com/sandstone/#tables
//         $stylesheet = "css/united.css"; // https://bootswatch.com/united/#tables
//         $stylesheet = "css/cyborg.css"; // https://bootswatch.com/cyborg/#tables
//         $stylesheet = "css/darkly.css"; // https://bootswatch.com/darkly/#tables
//         $stylesheet = "css/flatly.css"; // https://bootswatch.com/flatly/#tables
//         $stylesheet = "css/slate.css"; // https://bootswatch.com/slate/#tables
//         $stylesheet = "css/solar.css"; // https://bootswatch.com/solar/#tables


//Time Format
$time_format = array('Days', 'Hrs', 'Min', 'Sec');


// MySQL Settings ------------------------------------------------------------------


// DB hostname
$mostactive_dbHost = "localhost";

// DB username
$mostactive_dbUser = "";

// DB password
$mostactive_dbPass = "";

// DB name
$mostactive_dbName = "";


// End Of Settings ----------------------------------------------------------------
?>
</details>


<p align="right">(<a href="#readme-top">back to top</a>)</p>

### Screenshot

![image](https://github.com/PorcusorulMagic/K4-System-Time-Website/assets/98654600/30f85554-6194-4465-8acc-304747b95956)

**Website test:** https://www.panelcs.ro/test

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## License

Distributed under the GPL-3.0 License. See `LICENSE.md` for more information.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- CONTACT -->

## Contact

- **Discord:** porcusorulmagic#4908
- **Email:** eueumonster@gmail.com

<p align="right">(<a href="#readme-top">back to top</a>)</p>
