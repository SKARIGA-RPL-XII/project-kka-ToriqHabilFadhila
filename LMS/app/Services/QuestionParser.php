<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class QuestionParser
{
    public function extractFromDocx($filePath)
    {
        $zip = new \ZipArchive();
        if ($zip->open($filePath) !== true) {
            return '';
        }
        
        $xml = $zip->getFromName('word/document.xml');
        $zip->close();
        
        if (!$xml) {
            return '';
        }
        
        $dom = new \DOMDocument();
        $dom->loadXML($xml);
        $xpath = new \DOMXPath($dom);
        $xpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        
        $text = '';
        $paragraphs = $xpath->query('//w:p');
        
        foreach ($paragraphs as $para) {
            $paraText = '';
            $textInPara = $xpath->query('.//w:t', $para);
            foreach ($textInPara as $t) {
                $paraText .= $t->nodeValue;
            }
            
            if (!empty($paraText)) {
                $text .= $paraText . "\n";
            }
        }
        
        return $text;
    }

    public function parseMultipleChoice($text)
    {
        $text = str_replace("\r\n", "\n", $text);
        $text = str_replace("\r", "\n", $text);
        
        $questions = [];
        $lines = explode("\n", $text);
        
        $currentQuestion = null;
        $currentText = '';
        
        foreach ($lines as $line) {
            $trimmed = trim($line);
            
            // Skip empty lines
            if (empty($trimmed)) {
                continue;
            }
            
            // Check if this is a question number (1. or 1))
            if (preg_match('/^(\d+)\s*[\.\)]\s+(.+)$/', $trimmed)) {
                // Save previous question
                if ($currentQuestion !== null && !empty($currentText)) {
                    $parsed = $this->parseSingleQuestion($currentText);
                    if ($parsed) {
                        $questions[] = $parsed;
                    }
                }
                
                // Start new question
                $currentQuestion = $trimmed;
                $currentText = $trimmed . "\n";
            } else {
                // Add to current question
                if ($currentQuestion !== null) {
                    $currentText .= $trimmed . "\n";
                }
            }
        }
        
        // Don't forget last question
        if ($currentQuestion !== null && !empty($currentText)) {
            $parsed = $this->parseSingleQuestion($currentText);
            if ($parsed) {
                $questions[] = $parsed;
            }
        }
        
        return $questions;
    }

    private function parseSingleQuestion($text)
    {
        $text = trim($text);
        Log::info('Parsing question: ' . substr($text, 0, 100));
        
        // Extract soal dan poin dari baris pertama
        // Format: 1. Apa itu Android Studio?                    (Poin: 5)
        if (!preg_match('/^(\d+)\s*[\.\)]\s+(.+?)\s*\(\s*Poin\s*:\s*(\d+)\s*\)/i', $text, $match)) {
            Log::warning('Cannot parse question format');
            return null;
        }
        
        $soal = trim($match[2]);
        $poin = (int)$match[3];
        
        Log::info('Soal: ' . $soal . ', Poin: ' . $poin);
        
        if (empty($soal)) {
            return null;
        }
        
        // Extract pilihan
        $pilihan = [];
        
        // Match A
        if (preg_match('/A\s*[\.\)]\s*(.+?)(?=B\s*[\.\)]|$)/is', $text, $match)) {
            $pilihan[] = trim($match[1]);
        }
        
        // Match B
        if (preg_match('/B\s*[\.\)]\s*(.+?)(?=C\s*[\.\)]|$)/is', $text, $match)) {
            $pilihan[] = trim($match[1]);
        }
        
        // Match C
        if (preg_match('/C\s*[\.\)]\s*(.+?)(?=D\s*[\.\)]|$)/is', $text, $match)) {
            $pilihan[] = trim($match[1]);
        }
        
        // Match D
        if (preg_match('/D\s*[\.\)]\s*(.+?)(?=Jawaban|$)/is', $text, $match)) {
            $pilihan[] = trim($match[1]);
        }
        
        // Extract jawaban benar
        $jawabanBenar = 0;
        if (preg_match('/Jawaban\s*:\s*([A-D])/i', $text, $match)) {
            $jawabanBenar = ord(strtoupper($match[1])) - ord('A');
        }
        
        Log::info('Pilihan count: ' . count($pilihan) . ', Jawaban: ' . $jawabanBenar);
        
        if (count($pilihan) < 2 || empty($soal)) {
            Log::warning('Invalid question: pilihan=' . count($pilihan) . ', soal=' . $soal);
            return null;
        }
        
        return [
            'soal' => $soal,
            'pilihan' => $pilihan,
            'jawaban_benar' => $jawabanBenar,
            'poin' => $poin,
        ];
    }
}
