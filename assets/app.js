import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
// 1. On charge le CSS de Bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';

// 2. On charge le JS de Bootstrap (Pour les menus déroulants, modales, etc.)
import 'bootstrap';
import './styles/app.css';
console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
