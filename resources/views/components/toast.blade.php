<div id="toast"
class="fixed top-14 right-4 z-50 hidden bg-green-500 text-white text-sm py-2 px-4 rounded shadow-lg"></div>
<script>
    function showToast(message, bgColorClass) {
        var toast = document.getElementById('toast');
        toast.textContent = message;
        toast.classList.remove('hidden', 'bg-green-500', 'bg-red-500');
        toast.classList.add(bgColorClass);
        toast.style.opacity = 1;

        setTimeout(function() {
            toast.style.opacity = 0;
            setTimeout(function() {
                toast.classList.add('hidden');
            }, 500);
        }, 2000);
    }
</script>