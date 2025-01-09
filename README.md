# PHP Google Calendar Integration  

## Manage Google Calendar Appointments with PHP  

Easily book and read appointments from Google Calendar using this lightweight PHP integration. It enables seamless scheduling and appointment management with a simple API.  

## Features  
- Fetch available time slots from Google Calendar.  
- Create new events on your Google Calendar.  
- Streamline appointment management with minimal setup.  

## Requirements  
- PHP 7.4+  
- Composer (Dependency Manager)  
- Google Cloud Project with Google Calendar API enabled  
- OAuth 2.0 credentials  

---

## Setup  

### Step 1: Google Calendar API Setup  

1. **Create a Google Cloud Project**  
   - Visit [Google Cloud Console](https://console.cloud.google.com).  
   - Create or select an existing project.  

2. **Enable Google Calendar API**  
   - Navigate to *APIs & Services > Library*.  
   - Search for and enable *Google Calendar API*.  

3. **Generate API Key**  
   - Go to *APIs & Services > Credentials*.  
   - Select *Create Credentials > API Key*.  
   - Restrict the key for *HTTP Referrers* and select *Google Calendar API*.  

4. **Set Up OAuth 2.0 Credentials**  
   - In *Credentials*, click *Create Credentials > OAuth 2.0 Client ID*.  
   - Configure redirect URIs and download the `credentials.json` file.  

5. **Calendar Configuration**  
   - Access your Google Calendar's *Settings and Sharing*.  
   - Share the calendar with the OAuth service account and provide *Make changes to events* permission.  

---

### Step 2: Project Setup  

1. **Clone the Repository**  
   ```bash  
   git clone https://github.com/johnbenet009/php-google-calendar.git  
   cd php-google-calendar  
   ```  

2. **Install Dependencies**  
   ```bash  
   composer install  
   ```  

3. **Configure Credentials**  
   - Place `credentials.json` in the project directory.  

---

## Usage  

### Authentication  
Authenticate by opening the terminal and running:  
```bash  
curl http://your-domain.com/demo.php  
```  
Follow the provided URL, log in, and copy the `code` value from the redirected URL back into the terminal.  

---

### API Endpoints  

#### Fetch Available Time Slots  
```bash  
GET http://your-domain.com/calendar.php?date=YYYY-MM-DD  
```  

#### Create an Appointment  
```bash  
POST http://your-domain.com/calendar.php  
Content-Type: application/json  

{  
  "date": "YYYY-MM-DD",  
  "time": "HH:MM",  
  "summary": "Appointment Title",  
  "description": "Details of the appointment"  
}  
```  

---

### Examples  

1. **Get Time Slots**  
   ```bash  
   curl -X GET "http://your-domain.com/calendar.php?date=2025-01-08"  
   ```  
   Response:  
   ```json  
   {  
     "availableTimeSlots": ["09:00", "13:00", "14:00"],  
     "bookedTimeSlots": ["10:00", "11:00"]  
   }  
   ```  

2. **Book an Appointment**  
   ```bash  
   curl -X POST "http://your-domain.com/calendar.php" -H "Content-Type: application/json" -d '{  
     "date": "2025-01-08",  
     "time": "14:00",  
     "summary": "Team Meeting",  
     "description": "Quarterly updates"  
   }'  
   ```  
   Response:  
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
