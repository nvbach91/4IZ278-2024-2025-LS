<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    
    <!--Essentially only for product filtering-->
    <script>
        const filters = { color: '', size: '' };
        
        function filterProducts(type, value) {
            filters[type] = value;
            
            const cards = document.querySelectorAll('.card');
            
            cards.forEach(card => {
                const matchesColor = !filters.color || card.dataset.color === filters.color;
                const matchesSize = !filters.size || card.dataset.size === filters.size;
                
                if (matchesColor && matchesSize) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
    
    <!--Essentially only for collapsing accordions-->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('.accordion .item .header').on('click', function () {
                const $item = $(this).closest('.item');
                const $content = $item.find('.content');
                const $icon = $item.find('.toggle');
                
                $content.stop(true, true).slideToggle(200); 
                $icon.toggleClass('rotated');                
            });
        });
    </script>
</head>
<body>
    <x-navbar></x-navbar>
    
    @yield('content')
    
    <!--Toast-->
    @if(session('success'))
    <div id="toast-message" class="toast-success">
        {{ session('success') }}
    </div>
    
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast-message');
            if (toast) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300); // Wait for fade-out transition
            }
        }, 2000);
    </script>
    @endif
    <x-footer></x-footer>
</body>
</html>