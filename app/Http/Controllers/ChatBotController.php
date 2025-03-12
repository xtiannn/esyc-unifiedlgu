<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function index()
    {
        $messages = [
            ['text' => 'Welcome! I’m your assistant for user management, scholarships, incidents, emergencies, interviews, announcements, and more. How can I assist you today?', 'sender' => 'bot'],
            ['text' => 'User Management', 'sender' => 'bot', 'type' => 'suggestion'],
            ['text' => 'Scholarships', 'sender' => 'bot', 'type' => 'suggestion'],
            ['text' => 'Report Incident', 'sender' => 'bot', 'type' => 'suggestion'],
            ['text' => 'Emergency Alerts', 'sender' => 'bot', 'type' => 'suggestion'],
            ['text' => 'Interviews', 'sender' => 'bot', 'type' => 'suggestion'],
            ['text' => 'Announcements', 'sender' => 'bot', 'type' => 'suggestion'],
            ['text' => 'Help', 'sender' => 'bot', 'type' => 'suggestion']
        ];
        // session(['messages' => $messages, 'context' => 'start']);
        return view('chatbot', ['messages' => $messages]);
    }

    public function handle(Request $request)
    {
        $userInput = strtolower(trim($request->input('message')));
        $messages = session('messages', []);
        $context = session('context', 'start');
        $messages[] = ['text' => $userInput, 'sender' => 'user'];

        // === General Commands ===
        if (in_array($userInput, ['hi', 'hello', 'hey', 'greetings'])) {
            $messages[] = ['text' => 'Hello! How can I assist you today?', 'sender' => 'bot'];
            $this->addMainMenuSuggestions($messages);
            session(['context' => 'start']);
        } elseif ($userInput === 'help') {
            $messages[] = ['text' => 'I can assist with user accounts, scholarships, incident reporting, emergencies, interviews, announcements, and more. What do you need?', 'sender' => 'bot'];
            $this->addMainMenuSuggestions($messages);
            session(['context' => 'start']);
        } elseif (str_contains($userInput, 'thanks') || str_contains($userInput, 'thank you')) {
            $messages[] = ['text' => 'You’re welcome! Anything else I can do for you?', 'sender' => 'bot'];
            $messages[] = ['text' => 'Yes', 'sender' => 'bot', 'type' => 'suggestion'];
            $messages[] = ['text' => 'No', 'sender' => 'bot', 'type' => 'suggestion'];
            session(['context' => 'start']);
        } elseif ($userInput === 'back') {
            $messages[] = ['text' => 'Returning to the main menu...', 'sender' => 'bot'];
            $this->addMainMenuSuggestions($messages);
            session(['context' => 'start']);
        }

        // === User Management ===
        elseif (str_contains($userInput, 'user') || $userInput === 'user management') {
            if (str_contains($userInput, 'reset') || str_contains($userInput, 'password')) {
                $messages[] = ['text' => 'To reset your password, please provide your email or username.', 'sender' => 'bot'];
                $messages[] = ['text' => 'Enter email/username', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'How to reset', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'reset_password']);
            } elseif ($context === 'reset_password' && (str_contains($userInput, '@') || preg_match('/^[a-zA-Z0-9_-]+$/', $userInput))) {
                $messages[] = ['text' => "Sending reset link to '$userInput'... [Sample: Check your inbox].", 'sender' => 'bot'];
                $messages[] = ['text' => 'Check status', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Back', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'start']);
            } elseif (str_contains($userInput, 'how to reset')) {
                $messages[] = ['text' => 'Go to [login page], click "Forgot Password," enter your email, and follow the link sent to you.', 'sender' => 'bot'];
                $messages[] = ['text' => 'Try it now', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Back', 'sender' => 'bot', 'type' => 'suggestion'];
            } elseif (str_contains($userInput, 'role') || str_contains($userInput, 'permission')) {
                $messages[] = ['text' => 'Please provide your username to check your role.', 'sender' => 'bot'];
                session(['context' => 'check_role']);
            } elseif ($context === 'check_role' && preg_match('/^[a-zA-Z0-9_-]+$/', $userInput)) {
                $messages[] = ['text' => "Role for '$userInput': [Sample: Student]. Need more details?", 'sender' => 'bot'];
                $messages[] = ['text' => 'Yes', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Back', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'start']);
            } else {
                $messages[] = ['text' => 'I can help with account issues like passwords or roles. What do you need?', 'sender' => 'bot'];
                $messages[] = ['text' => 'Reset Password', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Check Role', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Back', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'user_management']);
            }
        }

        // === Scholarships ===
        elseif (str_contains($userInput, 'scholarship') || $userInput === 'scholarships') {
            if (str_contains($userInput, 'apply') || str_contains($userInput, 'how to')) {
                $messages[] = ['text' => 'To apply: 1) Visit [scholarship link], 2) Register with your details, 3) Submit required documents by the deadline.', 'sender' => 'bot'];
                $messages[] = ['text' => 'Eligibility', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Documents', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Deadlines', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'scholarship_apply']);
            } elseif (str_contains($userInput, 'status') || str_contains($userInput, 'check')) {
                $messages[] = ['text' => 'Please provide your application ID (e.g., SCH-12345) to check your status.', 'sender' => 'bot'];
                session(['context' => 'scholarship_status']);
            } elseif ($context === 'scholarship_status' && str_contains($userInput, 'sch-')) {
                $messages[] = ['text' => "Checking '$userInput'... [Sample: Under review, decision by March 20, 2025].", 'sender' => 'bot'];
                $messages[] = ['text' => 'More details', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Contact support', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'start']);
            } elseif (str_contains($userInput, 'documents') || str_contains($userInput, 'need')) {
                $messages[] = ['text' => 'Required documents: 1) ID proof (e.g., passport), 2) Academic transcripts, 3) Recommendation letter, 4) Financial statement (if applicable).', 'sender' => 'bot'];
                $messages[] = ['text' => 'Sample docs', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Upload help', 'sender' => 'bot', 'type' => 'suggestion'];
            } elseif (str_contains($userInput, 'sample') || str_contains($userInput, 'example')) {
                $messages[] = ['text' => 'Samples: Passport scan, latest semester grades, letter from a professor (PDF format).', 'sender' => 'bot'];
                $messages[] = ['text' => 'Back', 'sender' => 'bot', 'type' => 'suggestion'];
            } elseif (str_contains($userInput, 'eligibility') || str_contains($userInput, 'qualify')) {
                $messages[] = ['text' => 'Eligibility: 1) GPA 3.0+, 2) Full-time student, 3) Financial need (for some), 4) No prior awards (varies).', 'sender' => 'bot'];
                $messages[] = ['text' => 'Specific scholarships', 'sender' => 'bot', 'type' => 'suggestion'];
            } elseif (str_contains($userInput, 'deadline') || str_contains($userInput, 'when')) {
                $messages[] = ['text' => 'Deadlines: General scholarship - April 1, 2025; Merit-based - March 15, 2025. Check [link] for details.', 'sender' => 'bot'];
                $messages[] = ['text' => 'Apply now', 'sender' => 'bot', 'type' => 'suggestion'];
            } else {
                $messages[] = ['text' => 'Scholarship options: application, status, documents, eligibility, and more. What’s on your mind?', 'sender' => 'bot'];
                $messages[] = ['text' => 'Apply', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Check Status', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Documents', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Eligibility', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Deadlines', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'scholarships']);
            }
        }

        // === Incident & Case Reporting ===
        elseif (str_contains($userInput, 'incident') || $userInput === 'report incident') {
            if (str_contains($userInput, 'report') || $userInput === 'start reporting') {
                $messages[] = ['text' => 'Let’s report an incident. Please provide: 1) What happened? 2) Where? 3) When? (e.g., "Broken window, Room 12, 2 PM").', 'sender' => 'bot'];
                session(['context' => 'report_incident']);
            } elseif ($context === 'report_incident' && preg_match('/(what|where|when)/', $userInput)) {
                $messages[] = ['text' => "Logged: '$userInput'. [Sample: Case INC-456 created]. Anything else to add?", 'sender' => 'bot'];
                $messages[] = ['text' => 'Yes, add more', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'No, submit', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'incident_details']);
            } elseif ($context === 'incident_details' && $userInput === 'no, submit') {
                $messages[] = ['text' => 'Incident submitted! Case ID: [Sample: INC-456].', 'sender' => 'bot'];
                $messages[] = ['text' => 'Check status', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Back', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'start']);
            } elseif (str_contains($userInput, 'status') || str_contains($userInput, 'check')) {
                $messages[] = ['text' => 'Provide your case ID (e.g., INC-123) to check the status.', 'sender' => 'bot'];
                session(['context' => 'check_incident']);
            } elseif ($context === 'check_incident' && str_contains($userInput, 'inc-')) {
                $messages[] = ['text' => "Status for '$userInput': [Sample: In progress, team assigned].", 'sender' => 'bot'];
                $messages[] = ['text' => 'Update me', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Escalate', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'start']);
            } else {
                $messages[] = ['text' => 'I can help report an incident or check its status. What do you need?', 'sender' => 'bot'];
                $messages[] = ['text' => 'Report', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Check Status', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'incident']);
            }
        }

        // === Emergency Alerts ===
        elseif (str_contains($userInput, 'emergency') || $userInput === 'emergency alerts') {
            if (str_contains($userInput, 'view') || str_contains($userInput, 'what’s happening')) {
                $messages[] = ['text' => 'Active alerts: 1) Power outage in Sector A (March 11, 2025), 2) Fire drill scheduled (March 12, 2025).', 'sender' => 'bot'];
                $messages[] = ['text' => 'Details', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'How to respond', 'sender' => 'bot', 'type' => 'suggestion'];
            } elseif (str_contains($userInput, 'respond') || str_contains($userInput, 'how to')) {
                $messages[] = ['text' => 'Steps: 1) Stay calm, 2) Follow posted guidelines, 3) Contact [emergency number] if urgent.', 'sender' => 'bot'];
                $messages[] = ['text' => 'Specific emergency', 'sender' => 'bot', 'type' => 'suggestion'];
            } elseif (str_contains($userInput, 'fire') || str_contains($userInput, 'power')) {
                $messages[] = ['text' => "For '$userInput': Evacuate if necessary, report to [number], await instructions.", 'sender' => 'bot'];
                $messages[] = ['text' => 'Back', 'sender' => 'bot', 'type' => 'suggestion'];
            } else {
                $messages[] = ['text' => 'I can show alerts or help you respond to emergencies. What do you need?', 'sender' => 'bot'];
                $messages[] = ['text' => 'View Alerts', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'How to Respond', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'emergency']);
            }
        }

        // === Interviews ===
        elseif (str_contains($userInput, 'interview') || $userInput === 'interviews') {
            if (str_contains($userInput, 'schedule') || str_contains($userInput, 'book')) {
                $messages[] = ['text' => 'Please specify a date and time (e.g., "March 12, 10 AM").', 'sender' => 'bot'];
                session(['context' => 'schedule_interview']);
            } elseif (str_contains($userInput, 'slots') || str_contains($userInput, 'available')) {
                $messages[] = ['text' => 'Available slots: 1) March 12, 10 AM, 2) March 13, 2 PM, 3) March 14, 9 AM.', 'sender' => 'bot'];
                $messages[] = ['text' => 'March 12, 10 AM', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'March 13, 2 PM', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'March 14, 9 AM', 'sender' => 'bot', 'type' => 'suggestion'];
            } elseif ($context === 'schedule_interview' && preg_match('/march \d{1,2}/i', $userInput)) {
                $messages[] = ['text' => "Booking '$userInput'... [Sample: Confirmed for March 12, 10 AM].", 'sender' => 'bot'];
                $messages[] = ['text' => 'Confirm', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Cancel', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'confirm_interview']);
            } elseif ($context === 'confirm_interview' && $userInput === 'confirm') {
                $messages[] = ['text' => 'Interview confirmed! Reminder set for 24 hours prior.', 'sender' => 'bot'];
                $messages[] = ['text' => 'Back', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'start']);
            } else {
                $messages[] = ['text' => 'I can schedule an interview or show available slots. What’s your preference?', 'sender' => 'bot'];
                $messages[] = ['text' => 'Schedule', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Available Slots', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'interviews']);
            }
        }

        // === Announcements ===
        elseif (str_contains($userInput, 'announcement') || $userInput === 'announcements') {
            if (str_contains($userInput, 'latest') || str_contains($userInput, 'new')) {
                $messages[] = ['text' => 'Latest: 1) Campus event on March 15, 2025, 2) System maintenance on March 20, 2025.', 'sender' => 'bot'];
                $messages[] = ['text' => 'Details', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Previous', 'sender' => 'bot', 'type' => 'suggestion'];
            } elseif (str_contains($userInput, 'previous') || str_contains($userInput, 'old')) {
                $messages[] = ['text' => 'Previous: 1) Holiday on March 10, 2025, 2) Workshop on March 5, 2025.', 'sender' => 'bot'];
                $messages[] = ['text' => 'Latest', 'sender' => 'bot', 'type' => 'suggestion'];
            } elseif (str_contains($userInput, 'details')) {
                $messages[] = ['text' => 'Details: Campus event - 10 AM, Main Hall, open to all students.', 'sender' => 'bot'];
                $messages[] = ['text' => 'Back', 'sender' => 'bot', 'type' => 'suggestion'];
            } else {
                $messages[] = ['text' => 'I can share the latest or previous announcements. What do you want?', 'sender' => 'bot'];
                $messages[] = ['text' => 'Latest', 'sender' => 'bot', 'type' => 'suggestion'];
                $messages[] = ['text' => 'Previous', 'sender' => 'bot', 'type' => 'suggestion'];
                session(['context' => 'announcements']);
            }
        }

        // === Fallback with Google AI Studio (Gemini API) ===
        else {
            $geminiResponse = $this->callGeminiApi($userInput);
            if ($geminiResponse && isset($geminiResponse['intent'])) {
                $messages[] = ['text' => "I think you mean: {$geminiResponse['intent']}. Here’s what I can do:", 'sender' => 'bot'];
                $this->addMainMenuSuggestions($messages);
            } else {
                $messages[] = ['text' => 'Sorry, I didn’t catch that. Could you clarify or pick an option?', 'sender' => 'bot'];
                $this->addMainMenuSuggestions($messages);
            }
            session(['context' => 'start']);
        }

        session(['messages' => $messages]);
        return response()->json(['messages' => $messages]);
    }

    private function addMainMenuSuggestions(&$messages)
    {
        $messages[] = ['text' => 'User Management', 'sender' => 'bot', 'type' => 'suggestion'];
        $messages[] = ['text' => 'Scholarships', 'sender' => 'bot', 'type' => 'suggestion'];
        $messages[] = ['text' => 'Report Incident', 'sender' => 'bot', 'type' => 'suggestion'];
        $messages[] = ['text' => 'Emergency Alerts', 'sender' => 'bot', 'type' => 'suggestion'];
        $messages[] = ['text' => 'Interviews', 'sender' => 'bot', 'type' => 'suggestion'];
        $messages[] = ['text' => 'Announcements', 'sender' => 'bot', 'type' => 'suggestion'];
    }

    private function callGeminiApi($input)
    {
        try {
            $apiKey = env('GEMINI_API_KEY');
            $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=' . $apiKey;

            // Craft a prompt to detect intent
            $prompt = "Analyze the following user input and identify the intent (e.g., 'scholarship', 'incident', 'emergency', 'interview', 'announcement', 'user', or 'unknown'): '$input'. Return the intent as a JSON object like {\"intent\": \"scholarship\"}.";

            $response = Http::post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $generatedText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                return json_decode($generatedText, true);
            }

            Log::error('Gemini API call failed: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Gemini API call failed: ' . $e->getMessage());
            return null; // Fallback to rule-based if API fails
        }
    }
}
