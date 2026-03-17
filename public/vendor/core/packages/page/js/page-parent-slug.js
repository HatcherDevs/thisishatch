/**
 * Update permalink prefix when parent page is selected
 * The prefix (parent slug) appears in the non-editable part before the input field
 */
$(document).ready(function() {
    const $parentSelect = $('select[name="parent_id"]');
    const $slugInput = $('input[name="slug"]');
    const $prefixSpan = $('.slug-field-wrapper .input-group-text').first();
    const $slugCurrent = $('.slug-current'); // Hidden input that stores the actual slug
    
    if (!$parentSelect.length || !$slugInput.length || !$prefixSpan.length) {
        return;
    }

    // Store original prefix (base URL without parent slug)
    const originalPrefixText = $prefixSpan.text().trim();
    const originalPrefix = originalPrefixText.replace(/\/$/, ''); // Remove trailing slash
    
    // Store base slug (without parent prefix) when page loads
    let baseSlug = $slugInput.val();
    if (baseSlug && baseSlug.includes('/')) {
        // If slug contains /, extract just the last part
        const parts = baseSlug.split('/');
        baseSlug = parts[parts.length - 1];
        // Update input to show only base slug
        $slugInput.val(baseSlug);
    }
    
    // Cache for parent slugs
    const parentSlugsCache = {};
    let currentParentSlug = null;
    
    /**
     * Update the prefix display with or without parent slug
     */
    function updatePrefixDisplay(parentSlug) {
        currentParentSlug = parentSlug;
        
        if (parentSlug) {
            // Show: baseUrl/parent-slug/
            $prefixSpan.text(originalPrefix + '/' + parentSlug + '/');
        } else {
            // Show: baseUrl/ (original prefix)
            $prefixSpan.text(originalPrefixText);
        }
        
        // Update the full slug that will be saved
        updateFullSlug();
    }
    
    /**
     * Update the hidden input with full slug (parent/child or just child)
     */
    function updateFullSlug() {
        const currentSlug = $slugInput.val() || baseSlug;
        let fullSlug = currentSlug;
        
        if (currentParentSlug) {
            fullSlug = currentParentSlug + '/' + currentSlug;
        }
        
        // Update both visible input and hidden input
        if ($slugCurrent.length) {
            $slugCurrent.val(fullSlug);
        }
        
        // Also update the slug input value attribute for form submission
        $slugInput.attr('data-full-slug', fullSlug);
    }
    
    /**
     * Fetch parent slug and update prefix
     */
    function updateSlugPrefix(parentId) {
        if (!parentId || parentId === '0') {
            // No parent - show original prefix only
            updatePrefixDisplay(null);
            return;
        }

        // Check cache first
        if (parentSlugsCache[parentId]) {
            updatePrefixDisplay(parentSlugsCache[parentId]);
            return;
        }

        // Fetch parent slug via AJAX
        $.ajax({
            url: '/admin/pages/get-slug/' + parentId,
            method: 'GET',
            success: function(response) {
                if (response && response.slug) {
                    // Cache the result
                    parentSlugsCache[parentId] = response.slug;
                    // Update prefix display
                    updatePrefixDisplay(response.slug);
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch parent slug:', error);
            }
        });
    }
    
    /**
     * Handle parent selection change
     */
    $parentSelect.on('change', function() {
        const parentId = $(this).val();
        updateSlugPrefix(parentId);
    });
    
    /**
     * Keep track of base slug when user edits the slug field
     */
    $slugInput.on('input', function() {
        baseSlug = $(this).val();
        updateFullSlug();
    });
    
    // DON'T modify the slug input on form submit
    // Let the Model handle the parent slug automatically
    // The input should only contain the BASE slug (e.g., "mission")
    // The Model will check parent_id and add the parent slug automatically
    
    // Initialize: if parent is already selected on page load, update prefix
    const initialParentId = $parentSelect.val();
    if (initialParentId && initialParentId !== '0') {
        updateSlugPrefix(initialParentId);
    }
});
