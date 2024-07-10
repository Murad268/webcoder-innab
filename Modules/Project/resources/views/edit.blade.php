@extends('layouts.app')

@section('content')
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Layihə Redaktə et</h5>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-10">
            <div class="card col-span-2">
                <div class="card-body">
                    <div>
                        <form enctype="multipart/form-data" method="post" action="{{ route('project.update', $project->id) }}">
                            @csrf
                            @method('PUT')
                            <ul class="flex flex-wrap w-full text-sm font-medium text-center border-b border-slate-200 dark:border-zink-500 nav-tabs">
                                @php
                                $isFirst = true;
                                @endphp
                                @foreach($languages as $language)
                                <li class="group {{ $isFirst ? 'active' : ''}}">
                                    <a href="javascript:void(0);" data-tab-toggle="" data-target="{{ $language->code }}" class="inline-block px-4 py-2 text-base transition-all duration-300 ease-linear rounded-t-md text-slate-500 dark:text-zink-200 border border-transparent group-[.active]:text-custom-500 group-[.active]:border-slate-200 dark:group-[.active]:border-zink-500 group-[.active]:border-b-white dark:group-[.active]:border-b-zink-700 hover:text-custom-500 active:text-custom-500 dark:hover:text-custom-500 dark:active:text-custom-500 dark:group-[.active]:hover:text-white -mb-[1px]">{{ $language->code }}</a>
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
                                    <div class="block tab-pane {{ $isFirst ? 'block' : 'hidden'}}" id="{{ $language->code }}">
                                        <div class="grid grid-cols-1 gap-x-5 sm:grid-cols-2">
                                            <div class="mb-3">
                                                <label for="title_{{ $language->code }}" class="inline-block mb-2 text-base font-medium">Başlıq ({{ $language->code }})<span class="text-red-500">*</span></label>
                                                <input type="text" id="title_{{ $language->code }}" name="title[{{ $language->code }}]" value="{{ old('title.' . $language->code, $project->getTranslation('title', $language->code)) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                            </div>
                                            <div class="mb-3">
                                                <label for="card_description_{{ $language->code }}" class="inline-block mb-2 text-base font-medium">Kart Təsviri ({{ $language->code }})<span class="text-red-500">*</span></label>
                                                <textarea id="card_description_{{ $language->code }}" name="card_description[{{ $language->code }}]" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">{{ old('card_description.' . $language->code, $project->getTranslation('card_description', $language->code)) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="text_{{ $language->code }}" class="inline-block mb-2 text-base font-medium">Mətn ({{ $language->code }})<span class="text-red-500">*</span></label>
                                                <textarea id="text_{{ $language->code }}" name="text[{{ $language->code }}]" class="ckeditortext form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">{{ old('text.' . $language->code, $project->getTranslation('text', $language->code)) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="product_description_{{ $language->code }}" class="inline-block mb-2 text-base font-medium">Məhsul Təsviri ({{ $language->code }})</label>
                                                <textarea id="product_description_{{ $language->code }}" name="product_description[{{ $language->code }}]" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">{{ old('product_description.' . $language->code, $project->getTranslation('product_description', $language->code)) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="product_price_{{ $language->code }}" class="inline-block mb-2 text-base font-medium">Məhsul Qiyməti ({{ $language->code }})</label>
                                                <input type="text" id="product_price_{{ $language->code }}" name="product_price[{{ $language->code }}]" value="{{ old('product_price.' . $language->code, $project->getTranslation('product_price', $language->code)) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                            </div>
                                            <div class="mb-3">
                                                <label for="mobile_title_{{ $language->code }}" class="inline-block mb-2 text-base font-medium">Mobil Başlıq ({{ $language->code }})</label>
                                                <input type="text" id="mobile_title_{{ $language->code }}" name="mobile_title[{{ $language->code }}]" value="{{ old('mobile_title.' . $language->code, $project->getTranslation('mobile_title', $language->code)) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                            </div>
                                            <div class="mb-3">
                                                <label for="mobile_description_{{ $language->code }}" class="inline-block mb-2 text-base font-medium">Mobil Təsviri ({{ $language->code }})</label>
                                                <textarea id="mobile_description_{{ $language->code }}" name="mobile_description[{{ $language->code }}]" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">{{ old('mobile_description.' . $language->code, $project->getTranslation('mobile_description', $language->code)) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="mobile_qr_text_{{ $language->code }}" class="inline-block mb-2 text-base font-medium">Mobil QR Mətn ({{ $language->code }})</label>
                                                <textarea id="mobile_qr_text_{{ $language->code }}" name="mobile_qr_text[{{ $language->code }}]" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">{{ old('mobile_qr_text.' . $language->code, $project->getTranslation('mobile_qr_text', $language->code)) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="seo_title_{{ $language->code }}" class="inline-block mb-2 text-base font-medium">SEO Başlıq ({{ $language->code }})</label>
                                                <input type="text" id="seo_title_{{ $language->code }}" name="seo_title[{{ $language->code }}]" value="{{ old('seo_title.' . $language->code, $project->getTranslation('seo_title', $language->code)) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                            </div>
                                            <div class="mb-3">
                                                <label for="meta_keywords_{{ $language->code }}" class="inline-block mb-2 text-base font-medium">Meta Açar Sözlər ({{ $language->code }})</label>
                                                <textarea id="meta_keywords_{{ $language->code }}" name="meta_keywords[{{ $language->code }}]" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">{{ old('meta_keywords.' . $language->code, $project->getTranslation('meta_keywords', $language->code)) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="meta_description_{{ $language->code }}" class="inline-block mb-2 text-base font-medium">Meta Təsviri ({{ $language->code }})</label>
                                                <textarea id="meta_description_{{ $language->code }}" name="meta_description[{{ $language->code }}]" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">{{ old('meta_description.' . $language->code, $project->getTranslation('meta_description', $language->code)) }}</textarea>
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
                                    @foreach($project->images->where('type', 'image') as $image)
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
                                <label for="textArea" class="inline-block mb-2 text-base font-medium">İkon</label>
                                @if($project->images->where('type', 'image')->count() < 1) <input multiple name="image[]" type="file" class="cursor-pointer form-file border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                    @endif

                            </div>

                            <div style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">
                                    @foreach($project->images->where('type', 'product_image') as $image)
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
                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Məhsul rəsmi</label>
                                @if($project->images->where('type', 'product_image')->count() < 1) <input multiple name="product_image[]" type="file" class="cursor-pointer form-file border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                    @endif
                            </div>


                            <div style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">
                                    @foreach($project->images->where('type', 'mobile_product_qr') as $image)
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
                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Məhsul mobil QR</label>
                                @if($project->images->where('type', 'mobile_product_qr')->count() < 1) <input multiple name="mobile_product_qr[]" type="file" class="cursor-pointer form-file border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                    @endif
                            </div>



                            <div style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">
                                    @foreach($project->images->where('type', 'mobile_product_image') as $image)
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
                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Məhsul mobil rəsmi</label>
                                @if($project->images->where('type', 'mobile_product_image')->count() < 1)
                                <input multiple name="mobile_product_image[]" type="file" class="cursor-pointer form-file border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                @endif
                            </div>
                            <div class="grid grid-cols-1 gap-x-5 sm:grid-cols-2">
                                <div class="mb-3">
                                    <label for="seo_links" class="inline-block mb-2 text-base font-medium">SEO Linklər</label>
                                    <textarea name="seo_links" id="seo_links" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">{{ old('seo_links', $project->seo_links) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="seo_scripts" class="inline-block mb-2 text-base font-medium">SEO Skriptlər</label>
                                    <textarea name="seo_scripts" id="seo_scripts" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">{{ old('seo_scripts', $project->seo_scripts) }}</textarea>
                                </div>
                            </div>

                            <button type="submit" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                Redaktə et
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
