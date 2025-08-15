<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'hero_slides' => [
                [
                    'title' => 'Bridal Makeup Perfection',
                    'subtitle' => 'Your special day deserves the perfect look',
                    'image' => 'bridal-makeup.jpg'
                ],
                [
                    'title' => 'Party & Event Makeup',
                    'subtitle' => 'Stand out at every celebration',
                    'image' => 'party-makeup.jpg'
                ],
                [
                    'title' => 'Professional Photoshoot',
                    'subtitle' => 'Camera-ready looks that capture perfection',
                    'image' => 'photoshoot-makeup.jpg'
                ]
            ],
            'services' => [
                [
                    'name' => 'Bridal Makeup',
                    'description' => 'Complete bridal makeup package including trial session',
                    'price' => 299,
                    'icon' => 'ring'
                ],
                [
                    'name' => 'Party Makeup',
                    'description' => 'Glamorous party looks for special events',
                    'price' => 149,
                    'icon' => 'glass-cheers'
                ],
                [
                    'name' => 'Photoshoot Makeup',
                    'description' => 'Professional makeup for photography sessions',
                    'price' => 199,
                    'icon' => 'camera'
                ],
                [
                    'name' => 'Makeup Lessons',
                    'description' => 'Learn professional techniques one-on-one',
                    'price' => 99,
                    'icon' => 'graduation-cap'
                ]
            ],
            'packages' => [
                [
                    'name' => 'Basic Glam',
                    'price' => 149,
                    'features' => ['Professional makeup application', 'Basic contouring', 'Lipstick touch-up', '1 hour session']
                ],
                [
                    'name' => 'Premium Glam',
                    'price' => 249,
                    'features' => ['Complete transformation', 'Advanced contouring', 'Eye makeup with lashes', 'Touch-up kit', '1.5 hour session'],
                    'popular' => true
                ],
                [
                    'name' => 'Luxury Bridal',
                    'price' => 399,
                    'features' => ['Bridal trial session', 'Wedding day makeup', 'Premium lashes', 'Complete touch-up kit', '2+ hour session']
                ]
            ],
            'testimonials' => [
                [
                    'name' => 'Sarah Johnson',
                    'role' => 'Bride',
                    'rating' => 5,
                    'comment' => 'Absolutely amazing! She made me feel like a princess on my wedding day.'
                ],
                [
                    'name' => 'Emily Chen',
                    'role' => 'Event Client',
                    'rating' => 5,
                    'comment' => 'Professional, talented, and so easy to work with. Will definitely book again!'
                ],
                [
                    'name' => 'Maria Rodriguez',
                    'role' => 'Photoshoot Client',
                    'rating' => 5,
                    'comment' => 'The makeup for my photoshoot was flawless! The photos turned out incredible.'
                ]
            ]
        ];

        return view('welcome', compact('data'));
    }
}