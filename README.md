# SoundSpotlight

Welcome to "SoundSpotlight" - a specialized platform for exploring and discovering music albums. This app offers a
rich library of music albums across a wide range of genres. Find detailed information about various albums, each waiting
to be discovered. Music is a universal language, and SoundSpotlight helps users find albums that resonate with them.

# Table of Contents

1. [Features](#features)
2. [Technology Stack](#technology-stack)
3. [Database Design and Structure](#database-design-and-structure)
5. [Installation](#installation)
6. [Usage](#usage)
7. [Contact](#contact)

# Features

- **Browse Albums:** Discover a vast selection of music albums from various genres.
- **Detailed Albums Profiles:** Access comprehensive profiles for each album, including release dates, ratings,
  categories, languages, and reviews.
- **Advanced Search:** Utilize filters to search albums by title, artist name, category, and language to find exactly
  what you're looking for.
- **User Accounts:** Sign up to add albums, rate them, and engage with the community. Admins take care
  about atmosphere and content on our platform.
- **Responsive Design:** Enjoy a seamless browsing experience on any device with our fully responsive design.

# Technology Stack

A diverse set of technologies and tools ensures the platform is efficient, performant, and scalable. The key components
include:

1. **Front-end:**
    1. HTML for the structure
    2. CSS for the styles
    3. JS for client-side logic and functions
2. **Back-end:**
    1. PHP as a server-side language
    2. PostgreSQL as a database system
3. **Containerization**
    1. Docker for creating, deploying, and managing application containers
    2. Docker compose for managing multi-container Docker apps
4. **Version Control**
    1. Git for source code management and version control
    2. GitHub for hosting the repository

# Database Design and Structure

The database design is structured to ensure efficient data storage and retrieval. The main components include:

1. **Entity-Relationship Diagram (ERD):**
   The [ERD diagram](./docker/db/soundspotlight-database-erd.png) represents the database schema. This diagram helps to
   understand
   the relationships between different entities.
2. **Database Schema:**
   The [SQL file](./docker/db/soundspotlight-database) contains the SQL commands to create the database structure. It
   defines tables, relationships,
   sample data and other database elements.

# Installation

1. Clone the repository
2. Navigate to the project directory
3. Docker setup: Ensure Docker and Docker Compose are installed on the system. The project directory contains Docker
   configuration files in docker/db, docker/nginx, and docker/node directories, along with Dockerfile in each.
4. Build docker images: ```docker-compose build```
5. Start docker containers: ```docker-compose up```
6. Access the app: Now you can open the app by entering http://localhost:8080/ in your browser.

# Usage

## Login & registration view

User can easily create an account in Spotlight to get access to big albums library and community. After logging in,
system hold user session until log out and obey the permissions rules (admin console visible only for admins).

|                         Desktop                         |                        Mobile                         |
|:-------------------------------------------------------:|:-----------------------------------------------------:|
|    ![Login Desktop](./app-screens/login-desktop.png)    |    ![Login Mobile](./app-screens/login-mobile.png)    |
| ![Register Desktop](./app-screens/register-desktop.png) | ![Register Mobile](./app-screens/register-mobile.png) |

## Home / Dashboard

On Dashboard user can browse through all albums approved by admins that exists in the app. If he looks for a very
specific album, he can use a searching/filtering mechanism that works without page reloading. Additionally, each album
can be added to favorites albums by just clicking on heart icon on album tile.

|                       Desktop                        |                       Mobile                       |
|:----------------------------------------------------:|:--------------------------------------------------:|
| ![Home Desktop](./app-screens/dashboard-desktop.png) | ![Home Mobile](./app-screens/dashboard-mobile.png) |

## Album details

When album paid user attention he can read something more about it, by going into album details. On this page user finds
more information rather than on album tile, like full descriptions, some numbers and others people opinions. Of course
user can add his own opinion too.

|                              Desktop                              |                             Mobile                              |
|:-----------------------------------------------------------------:|:---------------------------------------------------------------:|
| ![Album details Desktop](./app-screens/album-details-desktop.png) | ![Album details Mobile](./app-screens/album-details-mobile.png) |

## Adding a review

Users can express their feelings about each album by leaving short comment and rate on scale from 1 to 5 stars.

|                           Desktop                           |                          Mobile                           |
|:-----------------------------------------------------------:|:---------------------------------------------------------:|
| ![Add review Desktop](./app-screens/add-review-desktop.png) | ![Add review Mobile](./app-screens/add-review-mobile.png) |

## Top albums

Based on albums ratings, SoungSpotlight prepares live refreshing rank with the 5 albums with the highest rates given by
people.

|                           Desktop                           |                          Mobile                           |
|:-----------------------------------------------------------:|:---------------------------------------------------------:|
| ![Top albums Desktop](./app-screens/top-albums-desktop.png) | ![Top albums Mobile](./app-screens/top-albums-mobile.png) |

## Favorites

Your favorites albums always with you - thanks to dedicated place in SoundSpotlight where you can find albums that catch
your attention.

|                          Desktop                          |                         Mobile                          |
|:---------------------------------------------------------:|:-------------------------------------------------------:|
| ![Favorites Desktop](./app-screens/favorites-desktop.png) | ![Favorites Mobile](./app-screens/favorites-mobile.png) |

## User profile

In user profile users have an ability to take a look on their whole activity in the app like added reviews and albums.
Additionally, they can change avatar here - everyone love customisation.

|                                 Desktop                                 |                                Mobile                                 |
|:-----------------------------------------------------------------------:|:---------------------------------------------------------------------:|
| ![Your reviews Desktop](./app-screens/user-profile-reviews-desktop.png) | ![Your reviews Mobile](./app-screens/user-profile-reviews-mobile.png) |
| ![Added albums Desktop](./app-screens/user-profile-albums-desktop.png)  | ![Added albums Mobile](./app-screens/user-profile-albums-mobile.png)  |

## Add album

User can be a contributor of the SoundSpotlight by adding his own (or not) albums. It is necessary to fill in only a few
fields and admin approval to see user's albums live.

|                          Desktop                          |                         Mobile                          |
|:---------------------------------------------------------:|:-------------------------------------------------------:|
| ![Add album Desktop](./app-screens/add-album-desktop.png) | ![Add album Mobile](./app-screens/add-album-mobile.png) |

## Admin console

Whole environment should be clean and free from violence. Responsible people should take control over this, so this is
why there is admin role in the app. They can approve or reject albums and reviews. They have also a power to nominate
someone to become an admin, they can revert this decision or even they can completely remove the user from the system.

|                                   Desktop                                   |                                  Mobile                                   |
|:---------------------------------------------------------------------------:|:-------------------------------------------------------------------------:|
| ![Pending reviews Desktop](./app-screens/admin-console-reviews-desktop.png) | ![Pending reviews Mobile](./app-screens/admin-console-reviews-mobile.png) |
|  ![Pending albums Desktop](./app-screens/admin-console-albums-desktop.png)  |  ![Pending albums Mobile](./app-screens/admin-console-albums-mobile.png)  |
|   ![Manage users Desktop](./app-screens/admin-console-users-desktop.png)    |   ![Manage users Mobile](./app-screens/admin-console-users-mobile.png)    |

# Contact

### Mateusz Sajdak

**Email:** [sajdak.mateusz.219\@gmail.com](mailto:sajdak.mateusz.219@gmail.com) </br>
**Linkedin:** https://www.linkedin.com/in/mateusz-sajdak/ </br>
**Dribbble:** https://dribbble.com/mateuszsajdak </br>