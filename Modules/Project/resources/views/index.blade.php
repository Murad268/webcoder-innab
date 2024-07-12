@extends('layouts.app')

@section('content')
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16"> Təlimlər </h5>
            </div>

        </div>

        <div class="card">
            <div class="card-body">
                <div id="alternativePagination_wrapper" class="dataTables_wrapper dt-tailwindcss">
                    <div class="grid grid-cols-12 lg:grid-cols-12 gap-3">
                        <div class="self-center col-span-12 lg:col-span-6">
                            <div style="display: flex; column-gap: 10px" class="dataTables_length" id="alternativePagination_length">
                                <a href="{{route('project.create')}}" style="display: flex; justify-content: center; align-items: center; cursor: pointer" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">əlavə et</a>
                                <a data-link="{{route('api.project.delete_selected_items')}}" style="cursor: pointer" type="button" class="delete-all px-4 py-3 text-sm text-purple-500 border border-purple-200 rounded-md bg-purple-50 dark:bg-purple-400/20 dark:border-purple-500/50">
                                    seçilənləri sil
                                </a>
                                <label> @if (session('status'))
                                    <div style="width: max-content" class="px-4 py-3 text-sm text-green-500 bg-white border border-green-300 rounded-md dark:bg-zink-700 dark:border-green-500" role="alert">{{ session('status') }}</div>
                                    @endif

                                    @if (session('error'))
                                    <div style="width: max-content" class="px-4 py-3 text-sm text-red-500 bg-white border border-red-300 rounded-md dark:bg-zink-700 dark:border-red-500" role="alert">{{ session('error') }}</div>
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div class="self-center col-span-12 lg:col-span-6 lg:place-self-end">
                            <div id="alternativePagination_filter" class="dataTables_filter">

                                <form action="">
                                    <label>axtar
                                        :

                                    </label>
                                    <input name="q" type="search" value="{{$q}}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 inline-block w-auto ml-2" placeholder="" aria-controls="alternativePagination">
                                </form>
                            </div>
                        </div>
                        <div class="my-2 col-span-12 overflow-x-auto lg:col-span-12">
                            <table id="alternativePagination" class="display dataTable w-full text-sm align-middle whitespace-nowrap" style="width:100%" aria-describedby="alternativePagination_info">
                                <thead class="border-b border-slate-200 dark:border-zink-500">
                                    <tr>
                                        <th class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4 text-slate-900 bg-slate-200/50 font-semibold text-left dark:text-zink-50 dark:bg-zink-600 dark:group-[.bordered]:border-zink-500 sorting_asc" tabindex="0" aria-controls="alternativePagination" rowspan="1" colspan="1" style="width: 270.867px;" aria-sort="ascending" aria-label="Name: activate to sort column descending">seç
                                        </th>
                                        <th class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4 text-slate-900 bg-slate-200/50 font-semibold text-left dark:text-zink-50 dark:bg-zink-600 dark:group-[.bordered]:border-zink-500" tabindex="0" aria-controls="alternativePagination" rowspan="1" colspan="1" style="width: 415.15px;" aria-label="Position: activate to sort column ascending">başlıq
                                        </th>

                                        <th class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4 text-slate-900 bg-slate-200/50 font-semibold text-left dark:text-zink-50 dark:bg-zink-600 dark:group-[.bordered]:border-zink-500" tabindex="0" aria-controls="alternativePagination" rowspan="1" colspan="1" style="width: 165.517px;" aria-label="Salary: activate to sort column ascending">kateqoriyası</a></label </th>
                                        <th class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4 text-slate-900 bg-slate-200/50 font-semibold text-left dark:text-zink-50 dark:bg-zink-600 dark:group-[.bordered]:border-zink-500" tabindex="0" aria-controls="alternativePagination" rowspan="1" colspan="1" style="width: 165.517px;" aria-label="Salary: activate to sort column ascending">status
                                        </th>
                                        <th class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4 text-slate-900 bg-slate-200/50 font-semibold text-left dark:text-zink-50 dark:bg-zink-600 dark:group-[.bordered]:border-zink-500" tabindex="0" aria-controls="alternativePagination" rowspan="1" colspan="1" style="width: 165.517px;" aria-label="Salary: activate to sort column ascending">əməliyyatlar
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr class="group-[.stripe]:even:bg-slate-50 group-[.stripe]:dark:even:bg-zink-600 transition-all duration-150 ease-linear group-[.hover]:hover:bg-slate-50 dark:group-[.hover]:hover:bg-zink-600 [&amp;.selected]:bg-custom-500 dark:[&amp;.selected]:bg-custom-500 [&amp;.selected]:text-custom-50 dark:[&amp;.selected]:text-custom-50">

                                        <td class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting_1">
                                            <input data-id='{{$item->id}}' id="checkboxCircle2" class="select-lang border rounded-full appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-green-500 checked:border-green-500 dark:checked:bg-green-500 dark:checked:border-green-500 checked:disabled:bg-green-400 checked:disabled:border-green-400" type="checkbox" value="">
                                        </td>



                                        <td class=" p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500">
                                            {{$item->title}}
                                        </td>
                                        <td class=" p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500">
                                            {{$item->category->title ?? ""}}
                                        </td>

                                        <td class=" p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500">
                                            @if($item->status)
                                            <div class="px-4 py-3 text-sm text-green-500 border border-transparent rounded-md bg-green-50 dark:bg-green-400/20">
                                                aktiv
                                            </div>
                                            @else
                                            <div class="px-4 py-3 text-sm text-red-500 border border-transparent rounded-md bg-red-50 dark:bg-red-400/20">
                                                passiv
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{route('project.edit', $item->id)}}" class="btn btn-phoenix-success me-1 mb-1" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen">
                                                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                        <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                                    </svg>
                                                </a>

                                                @if($item->status)
                                                @if($activeItemsCount < 2 or $items->count() < 2) <a style="cursor: none" class="btn btn-phoenix-danger me-1 mb-1" type="link">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info">
                                                            <circle cx="12" cy="12" r="10" />
                                                            <path d="M12 16v-4" />
                                                            <path d="M12 8h.01" />
                                                        </svg>
                                                        </a>
                                                        @else
                                                        <a href="{{route('project.changeStatusFalse',$item->id)}}" class="btn btn-phoenix-secondary me-1 mb-1 change_status_false" type="link">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-down">
                                                                <polyline points="22 17 13.5 8.5 8.5 13.5 2 7" />
                                                                <polyline points="16 17 22 17 22 11" />
                                                            </svg>
                                                        </a>
                                                        @endif

                                                        @else
                                                        <a href="{{route('project.changeStatusTrue',$item->id)}}" class="btn btn-phoenix-secondary me-1 mb-1 change_status_true" type="button">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up">
                                                                <polyline points="22 7 13.5 15.5 8.5 10.5 2 17" />
                                                                <polyline points="16 7 22 7 22 13" />
                                                            </svg>
                                                        </a>
                                                        @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>

                            </table>
                            <div style="margin:0 auto; width: max-content; margin-top: 30px" class="pagination">
                                {{ $items->appends(['q' => request()->input('q')])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end card-->
    </div>
    <!-- container-fluid -->
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.change_status_false, .change_status_true, .set_default_lang').forEach(link => {
        link.addEventListener('click', (e) => {
            if (e.target.matches('.change_status_false *')) {
                e.preventDefault();
                if (e.target.closest('a').getAttribute("href")) {
                    Swal.fire({
                        title: "Statusu dəyişmək istədiyinizdən əminsiniz?",
                        showCancelButton: true,
                        confirmButtonText: "bəli",
                        cancelButtonText: "xeyr",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire("status yeniləndi", "", "success")
                            window.location.href = e.target.closest('a').getAttribute("href");
                        } else if (result.isDenied) {
                            Swal.fire("yenilənmə zamanı xəta", "", "info");
                        }
                    });
                }
            } else if (e.target.matches('.change_status_true *')) {
                e.preventDefault();
                if (e.target.closest('a').getAttribute("href")) {
                    Swal.fire({
                        title: "Statusu dəyişmək istədiyinizdən əminsiniz?",
                        showCancelButton: true,
                        confirmButtonText: "bəli",
                        cancelButtonText: "xeyr",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire("status yeniləndi", "", "success")
                            window.location.href = e.target.closest('a').getAttribute("href");
                        } else if (result.isDenied) {
                            Swal.fire("yenilənmə zamanı xəta", "", "info");
                        }
                    });
                }
            } else if (e.target.matches('.set_default_lang *')) {
                e.preventDefault();
                if (e.target.closest('a').getAttribute("href")) {
                    Swal.fire({
                        title: "dili default tərin etmək istədiyinizdən əminsiniz?",
                        showCancelButton: true,
                        confirmButtonText: "bəli",
                        cancelButtonText: "xeyr",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire("uğurlu əməliyyat", "", "success")
                            window.location.href = e.target.closest('a').getAttribute("href");
                        } else if (result.isDenied) {
                            Swal.fire("əməliyyat zamanı xəta", "", "info");
                        }
                    });
                }
            }
        });
    });

    let selectedLangs = [];
    document.querySelectorAll('.select-lang').forEach(checkbox => {
        checkbox.addEventListener('change', (e) => {
            const id = e.target.getAttribute('data-id');
            if (e.target.checked) {
                if (!selectedLangs.includes(id)) {
                    selectedLangs.push(id);
                }
            } else {
                const index = selectedLangs.indexOf(id);
                if (index > -1) {
                    selectedLangs.splice(index, 1);
                }
            }
        });
    });

    document.querySelector('.delete-all').addEventListener('click', (e) => {
        e.preventDefault();
        const url = e.target.getAttribute('data-link');
        if (selectedLangs.length > 0) {
            Swal.fire({
                title: "seçilmiş məlumatların silinməsini istədiyinizdən əminsiniz?",
                showCancelButton: true,
                confirmButtonText: "bəli",
                cancelButtonText: "xeyr",
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                ids: selectedLangs
                            })
                        }).then(response => response.json())
                        .then(data => {
                            console.log(data);
                            Swal.fire(data.message, "", "success").then(() => {
                                location.reload();
                            });
                        }).catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', "", "error");
                        });
                }
            });
        } else {
            Swal.fire("heç bir data seçilməyib", "", "info");
        }
    });
</script>

@endpush
