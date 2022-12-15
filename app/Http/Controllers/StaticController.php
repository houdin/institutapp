<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class StaticController extends Controller
{
    public function specialEffects()
    {
        return Inertia::render('Solutions/Static/SpecialEffectsStatic');
    }

    public function modelisation3d()
    {
        return Inertia::render('Solutions/Static/3dModelisationStatic');
    }

    public function motionDesign()
    {
        return Inertia::render('Solutions/Static/MotionDesignStatic');
    }

    public function animation()
    {
        return Inertia::render('Solutions/Static/AnimationStatic');
    }

    public function tvBroadcast()
    {
        return Inertia::render('Solutions/Static/TvBroadcastStatic');
    }

    public function storyboard()
    {
        return Inertia::render('Solutions/Static/StoryboardStatic');
    }

    public function architecture()
    {
        return Inertia::render('Solutions/Static/ArchitectureStatic');
    }

    public function webApplication()
    {
        return Inertia::render('Solutions/Static/WebApplicationStatic');
    }

    public function marketing()
    {
        return Inertia::render('Solutions/Static/MarketingStatic');
    }
}
