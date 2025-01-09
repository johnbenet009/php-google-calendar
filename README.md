```markdown
# PHP Google Calendar Integration

## Manage Google Calendar Appointments with PHP

This lightweight PHP integration enables you to seamlessly book and manage appointments with Google Calendar. It provides a simple API for scheduling and appointment management.

## Features

- Fetch available time slots from Google Calendar.
- Create new events on your Google Calendar.
- Streamline appointment management with minimal setup.

## Requirements

- PHP 7.4+
- Composer (Dependency Manager)
- Google Cloud Project with Google Calendar API enabled
- OAuth 2.0 credentials

## Setup

### 1. Google Calendar API Setup

Before using the API, you need to set up your Google Cloud Project:

1. **Create a Google Cloud Project:**
   - Visit [Google Cloud Console](https://console.cloud.google.com).
   - Create or select an existing project.

2. **Enable Google Calendar API:**
   - Navigate to *APIs & Services > Library*.
   - Search for and enable *Google Calendar API*.

3. **Set Up OAuth 2.0 Credentials:**
   - Go to *APIs & Services > Credentials*.
   - Click *Create Credentials > OAuth 2.0 Client ID*.
   - Configure redirect URIs and download the `credentials.json` file.

4. **Calendar Configuration:**
   - Access your Google Calendar's *Settings and Sharing*.
   - Share the calendar with the OAuth service account and grant *Make changes to events* permission.

### 2. Project Setup

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/johnbenet009/php-google-calendar.git
   cd php-google-calendar
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   ```

3. **Configure Credentials:**
   - Place the `credentials.json` file, created in the previous step, in the project directory.

### 3. Initial Authentication

To perform the initial authentication and generate the `token.json` file for the Google Calendar API, follow these steps:

1. **Ensure the credentials.json file is available:**
   - Ensure you have placed the `credentials.json` file from the Google Cloud Console in the project directory.

2. **Run the script in CLI mode:**
   - Run the `php calendar.php` script using the PHP CLI (Command Line Interface). This is necessary because it prompts you to input an authorization code, which is not possible in a browser-based setup.
   ```bash
   php calendar.php
   ```

3. **Follow the authentication flow:**
   - When the script runs, it will detect that no `token.json` file exists and generate an authentication URL.
   - Open the URL in a browser to log in to your Google account and authorize the application.

4. **Get the authorization code:**
   - After authorizing, Google will provide an authorization code in the callback URL as `?code=****`. Copy this code.

5. **Input the code:**
   - Paste the code into the terminal where the script is running. The script will exchange the code for an access token and refresh token, then save them in the `token.json` file.

6. **Verify:**
   - The script should now be able to make authenticated requests to the Google Calendar API.

**Example of Running the Script:**
```bash
php calendar.php
```

If no `token.json` exists, you will see an output like this:
```
Auth URL:
https://accounts.google.com/o/oauth2/auth?access_type=offline&client_id=...
Enter verification code:
```

Copy the URL, paste it into your browser, and complete the authorization process. Copy the code provided by Google and paste it into the terminal. The script will create a `token.json` file in the same directory, which will be used for future authenticated requests.

## Usage

### API Endpoints

The API provides the following endpoints:

1. **Fetch Available Time Slots**  
   **GET** `http://your-domain.com/calendar.php?date=YYYY-MM-DD`

2. **Create an Appointment**  
   **POST** `http://your-domain.com/calendar.php`  
   **Content-Type:** `application/json`
   ```json
   {
     "date": "YYYY-MM-DD",
     "time": "HH:MM",
     "summary": "Appointment Title",
     "description": "Details of the appointment"
   }
   ```

### Examples

**Get Time Slots:**
```bash
curl -X GET "http://your-domain.com/calendar.php?date=2025-01-08"
```

**Response:**
```json
{
  "availableTimeSlots": ["09:00", "13:00", "14:00"],
  "bookedTimeSlots": ["10:00", "11:00"]
}
```

**Book an Appointment:**
```bash
curl -X POST "http://your-domain.com/calendar.php" -H "Content-Type: application/json" -d '{
  "date": "2025-01-08",
  "time": "14:00",
  "summary": "Team Meeting",
  "description": "Quarterly updates"
}'
```

**Response:**
```json
{
  "success": true,
  "eventLink": "https://www.google.com/calendar/event?eid=abc123"
}
```

---

## Notes

- Ensure proper calendar sharing and API configurations.
- Update time slots as needed in the source code.

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).
```
