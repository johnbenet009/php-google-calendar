<?php
require_once __DIR__ . '/vendor/autoload.php';

function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Calendar API PHP');
    $client->setScopes(Google_Service_Calendar::CALENDAR);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    if ($client->isAccessTokenExpired()) {
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($accessToken));
        }
    }

    return $client;
}

function createEvent($summary, $description, $date, $time, $duration = '01:00')
{
    $client = getClient();
    $service = new Google_Service_Calendar($client);

    $startDateTime = new DateTime("$date $time");
    $endDateTime = clone $startDateTime;
    $endDateTime->add(new DateInterval("PT" . explode(':', $duration)[0] . "H"));

    $event = new Google_Service_Calendar_Event([
        'summary' => $summary,
        'location' => 'Virtual',
        'description' => $description,
        'start' => [
            'dateTime' => $startDateTime->format(DateTime::ATOM),
            'timeZone' => 'Africa/Lagos',
        ],
        'end' => [
            'dateTime' => $endDateTime->format(DateTime::ATOM),
            'timeZone' => 'Africa/Lagos',
        ],
        'reminders' => [
            'useDefault' => false,
            'overrides' => [
                ['method' => 'email', 'minutes' => 24 * 60],
                ['method' => 'popup', 'minutes' => 10],
            ],
        ],
    ]);

    $calendarId = 'primary';
    $event = $service->events->insert($calendarId, $event);
    return $event->htmlLink;
}

function getBookedTimeSlots($date)
{
    $client = getClient();
    $service = new Google_Service_Calendar($client);

    $events = $service->events->listEvents('primary', [
        'timeMin' => (new DateTime("$date 00:00"))->format(DateTime::ATOM),
        'timeMax' => (new DateTime("$date 23:59"))->format(DateTime::ATOM),
        'singleEvents' => true,
        'orderBy' => 'startTime',
    ]);

    $bookedSlots = [];
    foreach ($events->getItems() as $event) {
        $startTime = new DateTime($event->start->dateTime);
        $bookedSlots[] = $startTime->format('H:i');
    }

    return $bookedSlots;
}

function getAvailableTimeSlots($date)
{
  $allSlots = [
    "09:00", "10:00", "11:00", "12:00", 
    "13:00", "14:00", "15:00", "16:00", 
    "17:00", "18:00", "19:00"
];


    $bookedTimeSlots = getBookedTimeSlots($date);
    $availableTimeSlots = array_diff($allSlots, $bookedTimeSlots);

    return [
        'availableTimeSlots' => array_values($availableTimeSlots),
        'bookedTimeSlots' => $bookedTimeSlots
    ];
}

if (php_sapi_name() === 'cli') {
    // CLI mode: Perform initial authentication and token generation
    getClient();
    echo "Token generated successfully.\n";
    exit;
}

// Handle requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['date'])) {
    $date = $_GET['date'];
    $slots = getAvailableTimeSlots($date);
    header('Content-Type: application/json');
    echo json_encode($slots);
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $date = $input['date'] ?? null;
    $time = $input['time'] ?? null;
    $summary = $input['summary'] ?? 'Appointment';
    $description = $input['description'] ?? 'Scheduled via API';

    if ($date && $time) {
        $eventLink = createEvent($summary, $description, $date, $time);
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'eventLink' => $eventLink]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
    }
    exit;
}
?>
