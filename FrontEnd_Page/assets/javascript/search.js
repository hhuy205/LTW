$(document).ready(function() {
    $('#search-input').on('keyup', function() {
        var query = $(this).val();
        if (query.length > 2) {  // Chỉ tìm kiếm khi nhập ít nhất 3 ký tự
            $.ajax({
                url: 'search_suggestions.php',
                type: 'GET',
                data: { term: query },
                success: function(data) {
                    $('#suggestions-box').html(data).show();
                }
            });
        } else {
            $('#suggestions-box').hide();
        }
    });

    $(document).on('click', '.suggestion-item', function() {
        $('#search-input').val($(this).text());
        $('#suggestions-box').hide();
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('#search-input').length) {
            $('#suggestions-box').hide();
        }
    });
});
