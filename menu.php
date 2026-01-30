<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        const productId = btn.dataset.id;

        // Check if already in wishlist on load
        fetch('wishlist_action.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=check&product_id=' + productId
        })
        .then(res => res.text())
        .then(status => {
            if (status === 'already_added') {
                btn.classList.add('active');
                btn.querySelector('i').classList.replace('far', 'fas');
            }
        });

        btn.addEventListener('click', function () {
            const isActive = this.classList.contains('active');
            const action = isActive ? 'remove' : 'add';

            fetch('wishlist_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=${action}&product_id=${productId}`
            })
            .then(res => res.text())
            .then(result => {
                if (result === 'added' || result === 'removed') {
                    this.classList.toggle('active');
                    const icon = this.querySelector('i');
                    icon.classList.toggle('far');
                    icon.classList.toggle('fas');
                    this.title = isActive ? 'Add to Wishlist' : 'Remove from Wishlist';
                }
            })
            .catch(() => {
                alert('Failed to update wishlist. Please try again.');
            });
        });
    });
});
</script>