<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    public function handleMessage(Request $request)
    {
        $userMessage = strtolower(trim($request->input('message')));
        $books = Book::all();
        
        $response = $this->processUserMessage($userMessage, $books);
        
        return response()->json(['response' => $response]);
    }
    
    private function processUserMessage($message, $books)
    {
        // Check for greetings
        if (preg_match('/\b(hi|hello|hey|good morning|good afternoon)\b/', $message)) {
            return "Hello! Im here to help you find books in our library. Which book are you looking for?";
        }
        
        // Check for help request
        if (preg_match('/\b(help|what can you do)\b/', $message)) {
            return "I can help you search for books in our library. Just tell me the title, author, or subject you're interested in.";
        }
        
        // Check for book search
        if (preg_match('/\b(book|find|search|look for)\b/', $message)) {
            $searchTerms = $this->extractSearchTerms($message);
            
            if (empty($searchTerms)) {
                return "What book would you like me to search for? Please provide a title, author, or subject.";
            }
            
            $matchingBooks = $this->searchBooks($searchTerms, $books);
            
            if ($matchingBooks->isEmpty()) {
                return "Couldn't find any books matching your search. Try different keywords or ask for help.";
            }
            
            return $this->formatBookResults($matchingBooks);
        }
        
        return "I'm here to help you find books in our library. You can ask me about specific titles, authors, or subjects.";
    }
    
    private function extractSearchTerms($message)
    {
        // Remove common search words to get the actual search terms
        $message = preg_replace('/\b(book|find|search|look for|about)\b/', '', $message);
        return array_filter(explode(' ', trim($message)));
    }
    
    private function searchBooks($searchTerms, $books)
    {
        return $books->filter(function ($book) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                // Use the correct column names from your migration
                if (stripos($book->book_name, $term) !== false || 
                    stripos($book->book_author, $term) !== false ||
                    stripos($book->category, $term) !== false) {
                    return true;
                }
            }
            return false;
        });
    }
    
    private function formatBookResults($books)
    {
        if ($books->count() === 1) {
            $book = $books->first();
            $status = $book->status === 'available' ? 'Available' : 'Currently Unavailable';
            return "I found this book: '{$book->book_name}' by {$book->book_author} (Category: {$book->category}, Year: {$book->year}, Status: {$status})";
        }
        
        $response = "I found {$books->count()} books:\n";
        foreach ($books as $book) {
            $status = $book->status === 'available' ? '✓ Available' : '✗ Unavailable';
            $response .= "• '{$book->book_name}' by {$book->book_author} - {$status}\n";
        }
        return $response;
    }
}
