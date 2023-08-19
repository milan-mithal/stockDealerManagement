/**
 * Delete Function
 */
function confirmDelete() {
    const deleteUrl = $('.deleteUrl').attr('data-url');
    location.href = deleteUrl;
}

