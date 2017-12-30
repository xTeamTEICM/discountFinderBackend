<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function get(Request $request)
    {
        return response()->json([
            'Τίτλος Εφαρμογής' => 'Discount Finder API',
            'Ομάδα' => 'xTEAMTEICM',
            'Προγραμματιστές' => [
                'Αβραάμ Κοβανίδης',
                'Ιορδάνης Κωστελίδης',
                'Κωνσταντίνος Μαντζαβέλας',
                'Παύλος Κοκοζίδης',
                'Νικόλαος Δελής',
                'Μιγκέλ Δάιος Γαλάν',
                'Αριστοτέλης Ποζίδης',
                'Σωτήριος Κελεσίδης',
                'Αρντίτ Ντόμι'
            ],
            'Υπέυθυνος Καθηγητής' => 'Νικόλαος Πεταλίδης',
            'Έκδοση' => env("APP_VERSION", 'local')
        ]);
    }
}
