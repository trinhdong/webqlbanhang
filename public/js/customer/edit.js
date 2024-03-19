$(document).ready(function () {
    $('#deleteDiscountModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const discountId = button.data('discount-id');
        $('#deleteDiscount').attr('data-discount-id', discountId);
    });

    $('#deleteDiscount').on('click', function () {
        const discountId = $(this).data('discount-id');
        $.ajax({
            url: '/customer/delete-discount/' + discountId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (response) {
                if (response.success) {
                    $(`#discount${discountId}`).remove();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error deleting data:', error);
            }
        });

        $('#deleteDiscountModal').modal('hide');
    });
});
