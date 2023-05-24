<ul class="md:flex-col md:min-w-full flex flex-col list-none">
    <li class="items-center">
        <a href="{{route('admin.dashboard')}}" class="text-xs uppercase py-3 {{ (request()->is('admin/dashboard')) ? 'text-pink-500' : 'text-gray-800' }} font-bold block  hover:text-pink-600">
            <i class="fas fa-tv mr-2 text-sm opacity-75"></i> Dashboard
        </a>
    </li>
    <li class="items-center">
        <a href="{{route('admin.school.index')}}" class="{{ (request()->is('admin/tenant*')) ? 'text-pink-500' : 'text-gray-800' }} text-xs uppercase py-3 font-bold block  hover:text-gray-600">
            <i class="fas fa-university mr-2 text-sm text-gray-400"></i> Schools
        </a>
    </li>
    <li class="items-center">
        <a href="{{route('admin.users.index')}}" class="{{ (request()->is('admin/users*')) ? 'text-pink-500' : 'text-gray-800' }} text-xs uppercase py-3 font-bold block  hover:text-gray-600">
            <i class="fas fa-university mr-2 text-sm text-gray-400"></i> Users
        </a>
    </li>
</ul>
