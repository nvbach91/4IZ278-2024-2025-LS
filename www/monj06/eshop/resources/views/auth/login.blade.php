@extends('components.layouts.loginL')


@section('content')
    <div class="w-full max-w-250 p-20 bg-white rounded-xl shadow-lg overflow-hidden">
        <form action="{{ route('login') }}" method="POST" class="max-w-sm mx-auto">
            @csrf
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                    email</label>
                <input type="email" name="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="name@flowbite.com" required value = "{{ old('email') }}" />
            </div>
            <div class="mb-5">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                    password</label>
                <input type="password" name="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required />
            </div>

            <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Ještě nemáte účet?
                <a href="{{ route('show.register') }}"
                    class="font-medium text-blue-600 hover:underline dark:text-blue-500">Registrujte
                    se</a>.
            </p>
            <div>
                <button type="submit"
                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Sign In
                </button>
            </div>
            <div>
                @if ($errors->any())
                    <ul class="px-4 py-2 bg-red-100">
                        @foreach ($errors->all() as $error)
                            <li class="my-2 text-red-500">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </form>
    </div>
@endsection

@section('footer')
    <!-- footer LiveWire component -->
    <livewire:footer />
@endsection
