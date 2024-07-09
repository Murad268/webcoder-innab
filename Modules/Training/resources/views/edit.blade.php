@extends('layouts.app')

@section('content')
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Təlim əlavə et</h5>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-10">
            <div class="card col-span-2">
                <div class="card-body">
                    <div>
                        <form enctype="multipart/form-data" method="post" action="{{route('training.update', $training->id)}}">
                            @csrf
                            @method("PATCH")
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
                                        <div class="grid grid-cols-1 gap-x-5 sm:grid-cols-2">
                                            <div class="mb-3">
                                                <label for="inputText1" class="inline-block mb-2 text-base font-medium">Kateroqiya adı ({{$language->code}})<span class="text-red-500">*</span></label>
                                                <input type="text" id="inputText1" name="title[{{ $language->code }}]" value="{{ old('title.' . $language->code, $training->getTranslation('title', $language->code)) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputText1" class="inline-block mb-2 text-base font-medium">Seo başlıq ({{$language->code}})<span class="text-red-500">*</span></label>
                                                <input type="text" id="inputText1" name="seo_title[{{ $language->code }}]" value="{{ old('seo_title.' . $language->code, $training->getTranslation('seo_title', $language->code)) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-x-5 sm:grid-cols-2">
                                            <div class="mb-3">
                                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Meta açar sözləri ({{$language->code}})</label>
                                                <textarea name="seo_keywords[{{ $language->code }}]" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="textArea" rows="3">{{ old('seo_keywords.' . $language->code, $training->getTranslation('seo_keywords', $language->code)) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Meta açıqlama ({{$language->code}})</label>
                                                <textarea name="seo_description[{{ $language->code }}]" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="textArea" rows="3">{{ old('seo_description.' . $language->code, $training->getTranslation('seo_description', $language->code)) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Qısa təsvir ({{$language->code}})</label>
                                                <textarea name="short_description[{{ $language->code }}]" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="textArea" rows="3">{{ old('short_description.' . $language->code, $training->getTranslation('short_description', $language->code)) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputText1" class="inline-block mb-2 text-base font-medium">Siyahı ({{$language->code}})</label>
                                                <textarea name="list[{{ $language->code }}]" class="ckeditortext form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="textArea" rows="3">{{ old('list.' . $language->code, $training->getTranslation('list', $language->code)) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputText1" class="inline-block mb-2 text-base font-medium">Yuxarı mətnin başlığı ({{$language->code}})</label>
                                                <input type="text" id="inputText1" name="top_text_title[{{ $language->code }}]" value="{{ old('top_text_title.' . $language->code, $training->getTranslation('top_text_title', $language->code)) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputText1" class="inline-block mb-2 text-base font-medium">Aşağı mətnin başlığı ({{$language->code}})</label>
                                                <input type="text" id="inputText1" name="bottom_text_title[{{ $language->code }}]" value="{{ old('bottom_text_title.' . $language->code, $training->getTranslation('bottom_text_title', $language->code)) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                            </div>
                                            <div class="mb-3">
                                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Yuxarı mətn ({{$language->code}})</label>
                                                <textarea name="top_text[{{ $language->code }}]" class="ckeditortext form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="textArea" rows="3">{{ old('top_text.' . $language->code, $training->getTranslation('top_text', $language->code)) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Aşağı mətn ({{$language->code}})</label>
                                                <textarea name="bottom_text[{{ $language->code }}]" class="ckeditortext form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="textArea" rows="3">{{ old('bottom_text.' . $language->code, $training->getTranslation('bottom_text', $language->code)) }}</textarea>
                                            </div>
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
                                    @foreach($training->images as $image)
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

                            @if($training->images->count()<1)
                                <div class="mb-3">
                                    <label for="textArea" class="inline-block mb-2 text-base font-medium">İkon</label>
                                    <input multiple name="image[]" type="file" class="cursor-pointer form-file border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                </div>
                            @endif
                            <div style="display: flex; column-gap: 35px">
                                @foreach($training->files as $file)
                                    <div style="position: relative; width: 250px; height: 250px;">
                                        @if(in_array(pathinfo($file->url, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'svg']))
                                            <a target="_blank" style="display: block; width: 100%; height: 100%;" href="{{ asset('storage/' . $file->url) }}">
                                                <img style="width: 100%; height: 100%;" src="{{ asset('storage/' . $file->url) }}" alt="">
                                            </a>
                                        @elseif(pathinfo($file->url, PATHINFO_EXTENSION) == 'pdf')
                                            <iframe style="width: 100%; height: 100%;" src="{{ asset('storage/' . $file->url) }}"></iframe>
                                            <button type="button" onclick="openPdf('{{ asset('storage/' . $file->url) }}')" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: white; padding: 10px; border: none; cursor: pointer;">
                                                Open PDF
                                            </button>
                                        @endif
                                        <a href="{{route('training.deleteFile', $file->id)}}" style="cursor: pointer; position: absolute; top: 0; right: 0; background-color: red; color: white; padding: 6px;" class="delete_image" data-id="{{ $file->id }}">
                                            X
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            @if($training->files->count()<1)
                                <div class="mb-3">
                                    <label for="textArea" class="inline-block mb-2 text-base font-medium">Tədris planı</label>
                                    <input multiple name="education_plan[]" type="file" class="cursor-pointer form-file border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                </div>
                            @endif


                            <div class="grid grid-cols-1 gap-x-5 sm:grid-cols-2">
                                <div class="mb-3">
                                    <label for="textArea" class="inline-block mb-2 text-base font-medium">Seo linklər</label>
                                    <textarea name="seo_links" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="textArea" rows="3">{{ old('seo_links', $training->seo_links) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="textArea" class="inline-block mb-2 text-base font-medium">Seo skriptlər</label>
                                    <textarea name="seo_scripts" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="textArea" rows="3">{{ old('seo_scripts', $training->seo_scripts) }}</textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <select name="category_id" class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                    <option value="0">Heç bir kateqoriyası yoxdur</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{ old('category_id', $training->category_id) == $category->id ? 'selected' : '' }}>{{$category->title}}</option>
                                    @endforeach
                                </select>
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
