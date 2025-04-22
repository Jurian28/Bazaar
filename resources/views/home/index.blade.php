<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <x-menu></x-menu>
    <div class="grid grid-cols-3 gap-3">
        <x-card href="/">
            <x-slot name="advertisementName">test</x-slot>
            <x-slot name="one">test</x-slot>
            <x-slot name="two">test</x-slot>
            <x-slot name="three">hoi</x-slot>
        </x-card>
    </div>
</body>
</html>