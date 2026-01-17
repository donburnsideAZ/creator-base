/**
 * Creator Base Customizer Live Preview
 * 
 * Updates the preview in real-time as customizer settings change
 */

(function($) {
    'use strict';

    // Accent color - live preview
    wp.customize('creator_base_accent_color', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--cb-color-accent', newval);
            
            // Calculate hover color (slightly darker)
            var hover = adjustBrightness(newval, -20);
            document.documentElement.style.setProperty('--cb-color-accent-hover', hover);
        });
    });

    /**
     * Adjust color brightness
     */
    function adjustBrightness(hex, steps) {
        hex = hex.replace('#', '');
        
        var r = parseInt(hex.substr(0, 2), 16);
        var g = parseInt(hex.substr(2, 2), 16);
        var b = parseInt(hex.substr(4, 2), 16);
        
        r = Math.max(0, Math.min(255, r + steps));
        g = Math.max(0, Math.min(255, g + steps));
        b = Math.max(0, Math.min(255, b + steps));
        
        return '#' + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
    }

})(jQuery);
