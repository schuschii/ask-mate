# Ask mate

## Overview
AskMate is a Q&A web application focusing on implementing user authentication, question and answer posting, tagging, and search functionalities.

## Features
- **User Authentication**: Users can register, log in, and log out securely.
- **Question Management**: Full CRUD (Create, Read, Update, Delete) functionality for questions.
- **Answers Management**: Full CRUD operations for posting and managing answers.
- **Tagging System**: Users can add or remove tags to categorize questions.
- **Search Functionality**: Search questions by keywords to quickly find relevant content.

## Tech Stack
- **Backend**: custom MVC framework written in PHP 
- **Frontend**: BladeOne templating engine
- **Database**: MariaDB

## Installation
### Prerequisites
- **PHP** >= 8.2
- **Composer** (PHP dependency manager)
- **MySQL** (or Dockerized MySQL instance)
- **BladeOne** >= 4.17
- **PHPUnit** >= 9.5 (for running unit tests)

### Setup Steps
1. Clone the repository:
    ```bash
    git clone https://github.com/schuschii/ask-mate
    ```
2. Install dependencies:
    ```bash
    composer install
    ```
3. Set up environment variables and configure database in `config.local.json`:
    ```bash
    cp config/config.json config/config.local.json
    ```
4. Set up database schema and import data:
    ```bash
    php script/load_database.php
    ```
5. Start the local development server:
    ```bash
    php -S localhost:8000 -t public
    ```
6. Run tests (optional):
   ```bash 
   composer test
   ```

## Contribution
Thanks to all the contributors!  
See [contributors](https://github.com/schuschii/ask-mate/graphs/contributors)

## License
This project is open-sourced under the MIT License.

## Contact
For any inquiries or support, reach out:
- **GitHub**: [contact](https://github.com/schuschii/ask-mate)


