$(document).ready(function() {
    var selectedUser = -1;

    $('#search-user').on('input', function() {
        const searchValue = $(this).val();
        selectedUser = -1; // reset

        if (searchValue.length >= 2) {
            $.getJSON('/people', { search: searchValue }, function(users) {
                $('#search-results').empty().show();

                users.slice(0, 5).forEach(function(user) {
                    $('#search-results').append(
                        $('<a href="#" class="list-group-item list-group-item-action"></a>')
                            .text(user.name)
                            .click(function(e) {
                                e.preventDefault();
                                $('#search-user').val(user.name);
                                $('#search-results').hide();
                            })
                    );
                });
            });
        } else {
            $('#search-results').hide();
        }

    });


    $('#search-user').on('keydown', function(e) {
        var items = $('#search-results .list-group-item');
        if ($('#search-results').is(':visible')) {
            if (e.keyCode === 40) { // ↓
                e.preventDefault();
                selectedUser = (selectedUser + 1) % items.length;
                items.removeClass('active');
                items.eq(selectedUser).addClass('active');
            } else if (e.keyCode === 38) { // ↑
                e.preventDefault();
                if (selectedUser <= 0) {
                    selectedUser = -1;
                    items.removeClass('active');// back to input
                } else {
                    selectedUser--;
                    items.removeClass('active');
                    items.eq(selectedUser).addClass('active');
                }
            } else if (e.keyCode === 13 && selectedUser !== -1) { // Enter, show suggest
                e.preventDefault();
                $('#search-user').val(items.eq(selectedUser).text());
                $('#search-results').hide();
                selectedUser = -1; // reset
            }
        } else if (e.keyCode === 13) { // Enter
            $(this).closest('form').submit(); // submit form
        }
    });


    $(document).on('click', function(e) {
        if (!$(e.target).closest('#search-user').length) {
            $('#search-results').hide();
        }
    });
});

