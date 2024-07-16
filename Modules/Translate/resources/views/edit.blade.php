@extends('layouts.app')

@section('content')
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Tərcüməni redaktə et</h5>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-10">
            <div class="card col-span-2">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="post" action="{{ route('translate.store') }}">
                        @csrf

                        <ul class="flex flex-wrap w-full text-sm font-medium text-center border-b border-slate-200 dark:border-zink-500 nav-tabs">
                            @php
                            $isFirst = true;
                            @endphp
                            @foreach($languages as $language)
                            <li class="group {{ $isFirst ? 'active' : '' }}">
                                <a href="javascript:void(0);" data-tab-toggle="" data-target="{{ $language->code }}" class="inline-block px-4 py-2 text-base transition-all duration-300 ease-linear rounded-t-md text-slate-500 dark:text-zink-200 border border-transparent group-[.active]:text-custom-500 group-[.active]:border-slate-200 dark:group-[.active]:border-zink-500 group-[.active]:border-b-white dark:group-[.active]:border-b-zink-700 hover:text-custom-500 active:text-custom-500 dark:hover:text-custom-500 dark:active:text-custom-500 dark:group-[.active]:hover:text-white -mb-[1px]">{{ $language->name }}</a>
                            </li>
                            @php
                            $isFirst = false;
                            @endphp
                            @endforeach
                        </ul>

                        <div style="border: 1px solid black; padding: 30px" class="mt-5 mb-4 tab-content">
                            @php
                            $isFirst = true;
                            @endphp
                            @foreach($languages as $language)
                            <div class="tab-pane {{ $isFirst ? 'block' : 'hidden' }}" id="{{ $language->code }}">
                                <div class="grid grid-cols-1 gap-x-5 sm:grid-cols-2">
                                    <div class="mb-3">
                                        <label for="value_{{ $language->code }}" class="inline-block mb-2 text-base font-medium">Tərcümə ({{ $language->name }})</label>
                                        <textarea name="value[{{ $language->code }}]" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500" id="value_{{ $language->code }}" rows="3">{{ old('value.' . $language->code, $model->getTranslation('value', $language->code)) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @php
                            $isFirst = false;
                            @endphp
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <label for="group" class="inline-block mb-2 text-base font-medium">Qrup</label>
                            <input type="text" id="group" name="group" value="{{ old('group', $model->group) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                        </div>
                        <div class="mb-3">
                            <label for="keyword" class="inline-block mb-2 text-base font-medium">Açar Söz</label>
                            <input type="text" id="keyword" name="keyword" value="{{ old('keyword', $model->keyword) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                        </div>

                        <button type="submit" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                            Yenilə
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.nav-tabs li a').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.nav-tabs li').forEach(li => li.classList.remove('active'));
            this.parentElement.classList.add('active');

            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.add('hidden'));
            document.getElementById(this.getAttribute('data-target')).classList.remove('hidden');
        });
    });
</script>
@endpush
