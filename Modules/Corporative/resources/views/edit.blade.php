@extends('layouts.app')

@section('content')
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Korporativi redaktə et</h5>
                <label> @if (session('status'))
                    <div style="width: max-content" class="px-4 py-3 text-sm text-green-500 bg-white border border-green-300 rounded-md dark:bg-zink-700 dark:border-green-500" role="alert">{{ session('status') }}</div>
                    @endif

                    @if (session('error'))
                    <div style="width: max-content" class="px-4 py-3 text-sm text-red-500 bg-white border border-red-300 rounded-md dark:bg-zink-700 dark:border-red-500" role="alert">{{ session('error') }}</div>
                    @endif
                </label>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-10">
            <div class="card col-span-2">
                <div class="card-body">
                    <div>
                        <form enctype="multipart/form-data" method="post" action="{{route('corporative.update', $model->id)}}">
                            @csrf
                            @method('PATCH')
                            <ul class="flex flex-wrap w-full text-sm font-medium text-center border-b border-slate-200 dark:border-zink-500 nav-tabs">
                                @php
                                $isFirst = true;
                                @endphp
                                @foreach($languages as $language)
                                <li class="group {{ $isFirst ? 'active' : ''}}">
                                    <a href="javascript:void(0);" data-tab-toggle="" data-target="{{$language->code}}" class="inline-block px-4 py-2 text-base transition-all duration-300 ease-linear rounded-t-md text-slate-500 dark:text-zink-200 border border-transparent group-[.active]:text-custom-500 group-[.active]:border-slate-200 dark:group-[.active]:border-zink-500 group-[.active]:border-b-white dark:group-[.active]:border-b-zink-700 hover:text-custom-500 active:text-custom-500 dark:hover:text-custom-500 dark:active:text-custom-500 dark:group-[.active]:hover:text-white -mb-[1px]">{{$language->name}}</a>
                                </li>
                                @php
                                $isFirst = false;
                                @endphp
                                @endforeach
                            </ul>

                            <div style="border: 1px solid black; padding: 30px" class="mt-5 mb-4 tab-content ">
                                <div class="mt-5 tab-content ">
                                    @php
                                    $isFirst = true;
                                    @endphp
                                    @foreach($languages as $language)
                                    <div class="block tab-pane {{ $isFirst ? 'block' : 'hidden'}}" id="{{$language->code}}">
                                        <div class="mb-3">
                                            <label for="inputText1" class="inline-block mb-2 text-base font-medium">Banner başlığı ({{$language->code}})<span class="text-red-500">*</span></label>
                                            <input type="text" id="inputText1" name="banner_title[{{ $language->code }}]" value="{{ old('banner_title.' . $language->code, $model->getTranslation('banner_title', $language->code)) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                        </div>
                                        <div class="mb-3">
                                            <label for="textArea" class="inline-block mb-2 text-base font-medium">Banner alt mətn ({{$language->code}})</label>
                                            <textarea name="banner_description[{{ $language->code }}]" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="textArea" rows="3">{{ old('banner_description.' . $language->code, $model->getTranslation('banner_description', $language->code)) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputText1" class="inline-block mb-2 text-base font-medium">Kontent başlığı ({{$language->code}})<span class="text-red-500">*</span></label>
                                            <input type="text" id="inputText1" name="content_title[{{ $language->code }}]" value="{{ old('content_title.' . $language->code, $model->getTranslation('content_title', $language->code)) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                        </div>
                                        <div class="mb-3">
                                            <label for="textArea" class="inline-block mb-2 text-base font-medium">Korporativ kontent üst mətn ({{$language->code}})</label>
                                            <textarea name="content_top_text[{{ $language->code }}]" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="textArea" rows="3">{{ old('content_top_text.' . $language->code, $model->getTranslation('content_top_text', $language->code)) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="textArea" class="inline-block mb-2 text-base font-medium">Korporativ kontent mətn ({{$language->code}})</label>
                                            <textarea name="content_text[{{ $language->code }}]" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="textArea" rows="3">{{ old('content_text.' . $language->code, $model->getTranslation('content_text', $language->code)) }}</textarea>
                                        </div>
                                    </div>
                                    @php
                                    $isFirst = false;
                                    @endphp
                                    @endforeach
                                </div>
                            </div>

                            <div style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">
                                    @foreach($model->images->where('type', 'image') as $image)
                                    <div style="position: relative; width: 250px; height: 250px;">
                                        <a target="_blank" style="display: block; width: 100%; height: 100%;" href="{{ asset('storage/' . $image->url) }}">
                                            <img style="width: 100%; height: 100%;" src="{{ asset('storage/' . $image->url) }}" alt="">
                                        </a>
                                        <a href="{{route('training.deleteFile', $image->id)}}" style="cursor: pointer; position: absolute; top: 0; right: 0; background-color: red; color: white; padding: 6px;" class="delete_image" data-id="{{ $image->id }}">
                                            X
                                        </a>
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Şəkil</label>
                                @if($model->images->where('type', 'image')->count()<1) <input name="image" type="file" class="cursor-pointer form-file border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                    @endif
                            </div>
                            <div style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">
                                    @foreach($model->images->where('type', 'banner') as $image)
                                    <div style="position: relative; width: 250px; height: 250px;">
                                        <a target="_blank" style="display: block; width: 100%; height: 100%;" href="{{ asset('storage/' . $image->url) }}">
                                            <img style="width: 100%; height: 100%;" src="{{ asset('storage/' . $image->url) }}" alt="">
                                        </a>
                                        <a href="{{route('training.deleteFile', $image->id)}}" style="cursor: pointer; position: absolute; top: 0; right: 0; background-color: red; color: white; padding: 6px;" class="delete_image" data-id="{{ $image->id }}">
                                            X
                                        </a>
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Banner</label>
                                @if($model->images->where('type', 'banner')->count()<1) <input name="banner" type="file" class="cursor-pointer form-file border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                    @endif
                            </div>
                            <button type="submit" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                Yenilə
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    @endsection

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openPdf(url) {
            window.open(url, '_blank');
        }
        document.querySelectorAll('.ckeditortext').forEach((textarea) => {
            CKEDITOR.replace(textarea);
        });

        document.querySelectorAll('.delete_image').forEach((button) => {
            button.addEventListener('click', function(e) {
                e.preventDefault()
                const href = this.getAttribute('href');
                Swal.fire({
                    title: 'Əminsiniz?',
                    text: "Bu şəkli silmək istədiyinizdən əminsiniz?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Bəli, silin!',
                    cancelButtonText: 'Xeyr, ləğv et!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            });
        });
    </script>

    @endpush
