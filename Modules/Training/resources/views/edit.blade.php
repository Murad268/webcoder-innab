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
                        <form method="post" action="{{route('training.store')}}">
                            @csrf
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
                                                <textarea name="list[{{ $language->code }}]" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="textArea" rows="3">{{ old('list.' . $language->code, $training->getTranslation('list', $language->code)) }}</textarea>
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
                                Əlavə et
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
    <script>
        document.querySelectorAll('.ckeditortext').forEach((textarea) => {
            CKEDITOR.replace(textarea);
        });

        document.addEventListener("DOMContentLoaded", function() {
            const tabLinks = document.querySelectorAll(".tab-link");
            const tabPanes = document.querySelectorAll(".tab-pane");
            tabLinks.forEach((elem) => {
                elem.addEventListener("click", () => {
                    const check = elem.getAttribute('data-check');
                    const id = elem.getAttribute('data-id');

                    tabLinks.forEach(link => {
                        if (link.getAttribute('data-check') === check) {
                            link.classList.remove("active");
                        }
                    });

                    elem.classList.add("active");

                    tabPanes.forEach(tab => {
                        if (tab.getAttribute('data-check') === check) {
                            tab.style.display = tab.getAttribute('data-id') === id ? "block" : "none";
                        }
                    });
                });
            });
        });
    </script>
    @endpush
