<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Debugbar Sample</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen">
<h1 class="text-2xl font-bold text-center mt-8 mb-4">Laravel Debugbar Sample</h1>
<div class="flex justify-center mt-8">
    <div class="bg-white p-8 rounded shadow w-96">
        <p class="text-sm text-gray-500 mb-4">
            Open the Debugbar toolbar at the bottom of the page and check the
            <strong>Queries</strong>, <strong>Messages</strong> and <strong>Timeline</strong> tabs.
        </p>
        <table class="w-full border border-gray-300 rounded">
            <thead>
            <tr class="bg-gray-100">
                <th class="py-2 px-4 border-b text-left">ID</th>
                <th class="py-2 px-4 border-b text-left">Title</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($items as $item)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $item->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $item->title }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
