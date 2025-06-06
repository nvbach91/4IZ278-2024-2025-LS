<div class="w-full max-w-250 p-20 bg-white rounded-xl shadow-lg overflow-hidden">
    <form class="max-w-sm mx-auto"  action="{{ route('update.product', $product->id) }}" method="GET">
        <div class="mb-5">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
            <input type="text" name="name"
                class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  border-gray-600 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500"
                value="{{ $product->name }}" required />
        </div>
        <div class="mb-5">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
            <textarea id="message" rows="4" name="description"
                class="block p-2.5 w-full text-sm text-gray-900  rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500  border-gray-600 placeholder-gray-400  focus:ring-blue-500 focus:border-blue-500"
                value="{{ $product->description }}" placeholder="Write a description...">{{ $product->description }}</textarea>
        </div>
        <div class="mb-5">
            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 ">price</label>
            <input type="text" name="price"
                class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  border-gray-600 placeholder-gray-400  focus:ring-blue-500 focus:border-blue-500"
                value="{{ $product->price }}" required />
        </div>
        <div class="mb-5">
            <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 ">Stock
            </label>
            <input type="text" name="stock"
                class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  border-gray-600 placeholder-gray-400  focus:ring-blue-500 focus:border-blue-500"
                value="{{ $product->stock }}" required />
        </div>
        <div class="mb-5">
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 ">Category
            </label>
            <input type="text" name="category"
                class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  border-gray-600 placeholder-gray-400  focus:ring-blue-500 focus:border-blue-500"
                value="{{ $product->category_id }}" required />
        </div>
        <div class="mb-5">
            <label for="image" class="block mb-2 text-sm font-medium text-gray-900 ">Image
            </label>
            <input type="text" name="image"
                class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  border-gray-600 placeholder-gray-400  focus:ring-blue-500 focus:border-blue-500"
                value="{{ $product->image }}" required />
        </div>
        <div>
            <button type="submit"
                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">
                Save
            </button>
        </div>
    </form>
    <a href="{{ route('delete.product', $product->id) }}"
        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 bg-red-600 hover:bg-red-700 focus:ring-red-900">Delete</a>
</div>
