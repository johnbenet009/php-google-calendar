# php-google-calendar

## Book and Read Google Calendar Appointments Using PHP the Simplest Way

This PHP project allows you to book and read appointments from Google Calendar. It provides an easy-to-use API integration for reading available time slots and creating calendar events.

## Features
- Retrieve available time slots from Google Calendar.
- Create new events on Google Calendar.
- Simplify the process of managing appointments through Google Calendar using PHP.

## Requirements
- PHP 7.4 or higher
- Composer for dependency management
- A Google Cloud Project with the Google Calendar API enabled
- OAuth 2.0 credentials (for accessing and modifying calendar events)

## Setup Instructions

### Steps to Set Up Google Calendar API with a Google Cloud Project

1. **Create a Google Cloud Project**
   - Go to the https://console.cloud.google.com.
   - Click *Create Project* or select an existing project.
   - Enter a project name and click *Create*.

2. **Enable Google Calendar API**
   - In the Cloud Console, navigate to *APIs & Services > Library*.
   - Search for *Google Calendar API*.
   - Click *Enable*.

3. **Create Credentials**
   - Go to *APIs & Services > Credentials*.
   - Click *Create Credentials > API Key*.
   - Copy the API key.
   - Click *Edit* on the API key to restrict it:
     - Set application restrictions to *HTTP referrers*.
     - Add your domain to allowed referrers.
     - Under *API restrictions*, select *Google Calendar API*.

4. **Set Up OAuth 2.0 (for write access)**
   - In *Credentials*, click *Create Credentials > OAuth 2.0 Client ID*.
   - Choose *Web application*.
   - Add authorized JavaScript origins (your domain).
   - Add authorized redirect URIs.
   - Click *Create*.
   - Download the client credentials JSON file and save it as `credentials.json`.

5. **Get Calendar ID**
   - Open https://calendar.google.com.
   - Locate your calendar under *My calendars*.
   - Click the three dots ... > *Settings and sharing*.
   - Scroll to *Integrate calendar*.
   - Copy the *Calendar ID* (usually the email address of the calendar).

6. **Configure Calendar Sharing**
   - In Calendar settings:
     - Go to *Share with specific people*.
     - Add your service account email (from the OAuth 2.0 setup).
     - Grant *Make changes to events* permission.

### Setting Up the Project

1. **Clone the Repository**
   Clone the repository to your local machine or server:

   ```bash
   git clone https://github.com/your-username/php-google-calendar.git
   cd php-google-calendar
   ```

2. **Install Dependencies**
   Run Composer to install the required libraries:

   ```bash
   composer install
   ```

3. **Configure the Project**
   - Place the downloaded `credentials.json` file in the project directory.
   - Ensure your Google Calendar is properly configured and shared with the service account email.

### How to Use
To get API key you must sign-in for the first time so open Terminal
```bash
curl http://your-domain.com/demo.php
```
This will give you an auth url, click on it, sign-in with your google calendar gmail account,  After auth, you'll be redirected to a url like: http://your-domain.com/calendar.php?code=JAX5RI5bzv5L67b-****-Eqv-Q&scope=https://www.googleapis.com/auth/calendar
Copy the url code value back to your terminal and hit Enter.


#### Getting Available Time Slots

To get the available time slots for a specific date, you can make a GET request:

```bash
GET http://your-domain.com/calendar.php?date=YYYY-MM-DD
```

#### Booking an Appointment

To create an event on Google Calendar, send a POST request with the appointment details:

```bash
POST http://your-domain.com/calendar.php
Content-Type: application/json

{
  "date": "YYYY-MM-DD",
  "time": "HH:MM",
  "summary": "Appointment Summary",
  "description": "Appointment Description"
}
```

This will create an event on your Google Calendar at the specified time and date.

### Example Usage

1. **Get Available Time Slots for a Specific Date**

   ```bash
   curl -X GET "http://your-domain.com/calendar.php?date=2025-01-08"
   ```

   **Response:**

   ```json
   {
     "availableTimeSlots": ["09:00", "13:00", "14:00", "15:00", "16:00"],
     "bookedTimeSlots": ["10:00", "11:00", "12:00"]
   }
   ```

2. **Create an Appointment**

   ```bash
   curl -X POST "http://your-domain.com/calendar.php" -H "Content-Type: application/json" -d '{
     "date": "2025-01-08",
     "time": "14:00",
     "summary": "Doctor Appointment",
     "description": "Annual check-up"
   }'
   ```

   **Response:**

   ```json
   {
     "success": true,
     "eventLink": "https://www.google.com/calendar/event?eid=abc123"
   }
   ```

### Notes
- Ensure that your Google Calendar is set up with the proper OAuth credentials.
- Make sure the calendar is shared with the appropriate users and service accounts.
- You can modify the available time slots in the code as needed.


## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).
