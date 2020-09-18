# tournament-manager
Web platform for creation and management of football tournaments. The system is capable of automatic generation and schedule of tournament games. Developed within the scope of Databases course from University of Coimbra.

## Table of Contents
- [Getting Started](#getting-started)
    - [Prerequisites](#prerequisites)
    - [Installation](#installation)
    - [Run](#run)
- [Features](#features)
- [Usage](#usage)
- [Contact](#contact)
---


## Getting Started

### Prerequisites
On Windows you can download XAMPP:
- [XAMPP Apache distribution](https://www.apachefriends.org/index.html) (contains Apache HTTP Server Apache + MariaDB + PHP)

### Installation

- Create a database with the code provided in the file ``futebolamador.sql``
- Create a database user and give it read and write access to *futebolamador* database 
- Place the project in a folder served by APACHE HTTP SERVER (example: xampp\htdocs)
- Update the ``connect.php`` file with the name and password of the user previously created

### Run

Access the browser at: ``localhost/tournament-manager/tournament.php``

## Features

- Access and edit user profile
    - Personal information (editable), teams and tournaments in which the user is a player and/or captain and manager respectively.
- Tournament creation
    - The user must provide a name, date and week day(s), with the desired start/end hours and field where the games will take place.
- List tournaments: tournament status and number of teams registered 
    - Tournament details: week day(s) and time schedule, field, cost of the field, teams, team status and captain.
    - Tournament game details: round robin schedule (date and time), teams and field.
- List and edit football fields: name, address and cost
- Tournament management (only users with management privileges)
    - Notification of past game results and teams created within a tournament managed by user;
    - Change start/end dates of a tournament;
    - Change team captain and promote team captain as tournament manager;
    - List and details of tournaments managed by user;
    - Start a new tournament - comprises three phases:
        1. Display "Generate Games" option

            If a tournament has at least two complete teams registered, the option to generate games appears. The user must indicate the number of times (1-2) each team plays every other team and then click on the “Generate Games” button. 
        2. Game generation

            The system automatically generates and schedules the games, for all completed teams, based on the details of tournament configuration. Teams are organized according to the rules of single or doubled round-robin tournament football (all-play-all once or twice respectively). 
            
            - **Game Generation Algorithm**: Creation of a list representing the pairs between all the teams. Save the pairs of teams. The team in second place is placed at the bottom of the list and all the remaining teams, except the first, rotate one position to the left. Repeat previous steps until the list of teams returns to initial state (single round robin schedule). Repeat the process if the robin robin schedule is double.  
        3. Start tournament

            The user can view all the details of the games generated. He can still delete a game or return to the previous menu to change tournament settings before starting the tournament definitely.
- Validation and Error Handling
    - Required form fields, date and hour validation and database incompatibility check in tournament creation 

## Usage

From the home page a user can access and edit his profile by clicking on the top right icon or select the desired option in the sidebar.

The structure of the application (pages) is as follows (information between ``()`` can be hidden if the required conditions are not satisfied): 

```
-> View profile -> Edit profile

-> Edit profile

-> Create tournament

-> Tournament management -> Manage tournament -> (Generate Games -> Start tournament)
    
                         -> Tournament details -> (Game details)

-> Football field management -> Create football field

-> List tournaments -> Tournament details -> (Game details)
```
 
## Contact
Created by [@filipamartins](https://github.com/filipamartins) - feel free to contact me through filipa.af.martins@gmail.com.