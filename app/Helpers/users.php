<?php

namespace App\Helpers;
use Codedge\Fpdf\Fpdf\Fpdf;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use App\Models\Affiliate;
use App\Models\Client;

class users
{
    public function clients(): ?Client
    {
        $user = auth()->user();

        if ($user instanceof Client) {
            return $user;
        }

        return null;
    }

    public function affiliate(): ?Affiliate
    {
        $user = auth()->user();

        if ($user instanceof Affiliate) {
            return $user;
        }

        return null;
    }
}