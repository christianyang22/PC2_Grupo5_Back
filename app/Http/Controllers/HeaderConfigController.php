<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HeaderConfig;

class HeaderConfigController extends Controller
{
    public function get()
    {
        $cfg = HeaderConfig::first();
        if (! $cfg) {
            return response()->json([
                'backgroundColor' => '#ffffff',
                'headerColor'     => 'rgba(255,255,255,0.9)',
                'buttonColor'     => '#28a745',
                'hoverColor'      => '#218838',
            ]);
        }

        return response()->json([
            'backgroundColor' => $cfg->background_color,
            'headerColor'     => $cfg->header_color,
            'buttonColor'     => $cfg->button_color,
            'hoverColor'      => $cfg->hover_color,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'backgroundColor' => 'required|string',
            'headerColor'     => 'required|string',
            'buttonColor'     => 'required|string',
            'hoverColor'      => 'required|string',
        ]);

        $cfg = HeaderConfig::first() ?: new HeaderConfig;
        $cfg->background_color = $data['backgroundColor'];
        $cfg->header_color     = $data['headerColor'];
        $cfg->button_color     = $data['buttonColor'];
        $cfg->hover_color      = $data['hoverColor'];

        $cfg->updated_by = Auth::id();

        $cfg->save();

        return response()->json([
            'backgroundColor' => $cfg->background_color,
            'headerColor'     => $cfg->header_color,
            'buttonColor'     => $cfg->button_color,
            'hoverColor'      => $cfg->hover_color,
        ]);
    }
}