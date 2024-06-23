# Halinfinity TEST 1: Sign in with Google (PHP)

This project demonstrates how to implement Google Sign-In using PHP. Follow the steps below to set up the project and get it running.

## Getting Started

### Prerequisites

- PHP installed on your system.
- Composer installed on your system.
- Access to Google Cloud Console to create and manage your credentials.

### Setup Instructions

1. **Clone the Repository**

   Clone this repository to your local machine using the following command:

   ```bash
   git clone https://github.com/yourusername/halinfinity-signin-google-php.git
   cd halinfinity-signin-google-php
   ```

2. **Install Dependencies**

   Navigate to the project directory and install the required dependencies using Composer:

   ```bash
   composer install
   ```

3. **Prepare Google Credentials**

   - Make a copy of `client_credentials.example.json` and rename it to `client_credentials.json`:

     ```bash
     cp client_credentials.example.json client_credentials.json
     ```

   - Update `client_credentials.json` with your Google Console credentials. You can obtain these credentials from the [Google Cloud Console](https://console.cloud.google.com/).

4. **Run the Project**

   Start the PHP built-in server to run the project:

   ```bash
   php -S localhost:8000
   ```

5. **Access the Application**

   Open your web browser and navigate to [http://localhost:8000](http://localhost:8000) to see the Google Sign-In page.

### Folder Structure

- **/materials**: Contains the example Google client credentials file.

### Updating Google Credentials

To update your Google credentials:

1. Go to the [Google Cloud Console](https://console.cloud.google.com/).
2. Navigate to the Credentials section.
3. Create or access your OAuth 2.0 Client IDs.
4. Copy the necessary details and update them in `client_credentials.json`.

## Troubleshooting

If you encounter any issues, ensure that:

- Your `client_credentials.json` file is correctly configured with valid Google credentials.
- You have enabled the necessary APIs in the Google Cloud Console.
- Your PHP environment meets all the prerequisites.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Acknowledgements

- [Google Identity Platform](https://developers.google.com/identity)
- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/)

## Contact

For further information or issues, please contact [Philip James Ajagabos](ajagabos007@gmail.com).

---

Happy coding!