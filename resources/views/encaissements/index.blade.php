@extends('app', ['page_title' => "Encaissements"])

@section('app_content')

    <section class="section">

        <div class="container">

            <div class="tw-bg-white tw-shadow-md tw-rounded tw-px-3 md:tw-px-8 tw-pt-3 md:tw-pt-6 tw-pb-3 md:tw-pb-8 tw-mb-4">

                <div class="tw-mb-4">

                    <h2 class="tw-text-blue-600 tw-text-lg tw-font-bold tw-mb-3 tw-border-b tw-border-gray-400 tw-pb-2">Liste des Encaissements</h2>

                    <!-- SEARCH FORM -->

                    <search-form
                        group="encaissement-search"
                        url="{{ route('encaissements.fetch') }}"
                        :params="{
                            search: '',
                            per_page: {{ $defaultPerPage }},
                            page: 1,
                            order_by: 'DatePaid:asc'
                            }"
                        v-slot="{ params, update, change, clear, processing }"
                    >

                        <form class="tw-grid tw-grid-cols-8 tw-col-gap-4 tw-pb-3 tw-border-b tw-border-gray-400">
                            <div class="tw-col-span-8 md:tw-col-span-4">
                                <label class="tw-block tw-uppercase tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2" for="search">
                                    Recherche
                                </label>
                                <div class="tw-relative">
                                    <span
                                        v-if="params.search"
                                        @click="clear({ search: '' })"
                                        class="tw-absolute tw-top-0 tw-right-0 tw-mt-4 mr-4 tw-text-gray-500 tw-cursor-pointer"
                                    >
                                        <times-circle
                                            class="tw-fill-current tw-h-4 tw-pointer-events-none"
                                        ></times-circle>
                                    </span>
                                    <input
                                        v-model="params.search"
                                        @input="update"
                                        @keydown.enter.prevent
                                        type="text"
                                        id="search"
                                        name="search"
                                        class="tw-appearance-none tw-block tw-w-full tw-bg-gray-200 focus:tw-bg-white tw-text-gray-700 tw-border tw-border-gray-400 focus:tw-border-gray-500 tw-rounded-sm tw-py-3 tw-pl-4 tw-pr-10 tw-mb-3 md:tw-mb-0 tw-leading-tight focus:tw-outline-none"
                                        placeholder="Rechercher..."
                                    >
                                </div>
                            </div>
                            <div class="tw-col-span-4 md:tw-col-span-2">
                                <label
                                    for="order_by"
                                    class="tw-block tw-uppercase tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2"
                                >
                                    Trier par
                                </label>
                                <div class="relative">
                                    <select
                                        v-model="params.order_by"
                                        @change="change"
                                        id="order_by"
                                        class="tw-appearance-none tw-block tw-w-full tw-bg-gray-200 focus:tw-bg-white tw-text-gray-700 tw-border tw-border-gray-400 focus:tw-border-gray-500 tw-rounded-sm tw-py-3 tw-pl-4 pr-8 tw-leading-tight focus:tw-outline-none"
                                    >
                                        <option value="DatePaid:asc">Date Paiement ASC</option>
                                        <option value="DatePaid:desc">Date Paiement DESC</option>
                                        <option value="PaymentKey:asc">Num. Paiement ASC</option>
                                        <option value="PaymentKey:desc">Num. Paiement DESC</option>
                                    </select>
                                    <select-angle></select-angle>
                                </div>
                            </div>
                            <div class="tw-col-span-4 md:tw-col-span-2">
                                <label
                                    for="per_page"
                                    class="tw-block tw-uppercase tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2"
                                >
                                    Par Page
                                </label>
                                <div class="tw-relative">
                                    <select
                                        v-model="params.per_page"
                                        @change="change"
                                        id="per_page"
                                        class="tw-appearance-none tw-block tw-w-full tw-bg-gray-200 focus:tw-bg-white tw-text-gray-700 tw-border tw-border-gray-400 focus:tw-border-gray-500 tw-rounded-sm tw-py-3 tw-pl-4 tw-pr-8 tw-leading-tight focus:tw-outline-none"
                                    >
                                        <option
                                            v-for="perPage in {{ $perPage }}"
                                            :value="perPage"
                                        >@{{ perPage }}</option>
                                    </select>
                                    <select-angle></select-angle>
                                </div>
                            </div>
                        </form>

                    </search-form>

                    <!--/ SEARCH FORM -->


                    <!-- RESULTS -->

                    <search-results group="encaissement-search" v-slot="{ total, records }">

                        <div class="tw-text-sm">

                            <div class="tw-flex tw-flex-wrap tw-p-4 tw-bg-gray-700 tw-text-white tw-rounded-sm">
                                <div class="tw-flex-auto tw-pr-3">Total : @{{ total }}</div>
                            </div>

                            <template v-if="records.length">

                                <table class="table-auto">
                                    <thead>
                                    <tr>
                                        <th class="tw-px-4 tw-py-2">Num. Paiement</th>
                                        <th class="tw-px-4 tw-py-2">Num. Facture</th>
                                        <th class="tw-px-4 tw-py-2">Num. Chèque</th>
                                        <th class="tw-px-4 tw-py-2">Banque</th>
                                        <th class="tw-px-4 tw-py-2">Description</th>
                                        <th class="tw-px-4 tw-py-2">Localité</th>
                                        <th class="tw-px-4 tw-py-2">Montant Final</th>
                                        <th class="tw-px-4 tw-py-2">Date Paiement</th>
                                        <th class="tw-px-4 tw-py-2">Détails</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="record in records"
                                            :key="record.id"
                                            class="tw-px-4 tw-border-b tw-border-dashed tw-border-gray-400 tw-text-gray-700 hover:tw-bg-gray-100"
                                        >
                                            <td class="tw-px-4 tw-py-2">
                                                <span class="tw-text-sm">@{{ record.PaymentKey }}</span>
                                            </td>
                                            <td class="tw-px-4 tw-py-2">
                                                <span class="tw-text-sm">@{{ record.ReceiptNum }}</span>
                                            </td>
                                            <td class="tw-px-4 tw-py-2">
                                                <span class="tw-text-sm">@{{ record.Reference }}</span>
                                            </td>
                                            <td class="tw-px-4 tw-py-2">
                                                <span class="tw-text-sm">@{{ record.BankName }}</span>
                                            </td>
                                            <td class="tw-px-4 tw-py-2">
                                                <span class="tw-text-sm tw-w-36">@{{ record.PaymentID }}</span>
                                            </td>
                                            <td class="tw-px-4 tw-py-2">
                                                <span class="tw-text-sm" v-if="record.agence">
                                                    @{{ record.agence.LocationName }}
                                                </span>
                                            </td>
                                            <td class="tw-px-4 tw-py-2">
                                                <span class="tw-text-sm">@{{ record.Final_TotalAmountPaid | formatNumber }}</span>
                                            </td>
                                            <td class="tw-px-6 tw-py-2">
                                                <span class="tw-text-sm">@{{ record.DatePaid | formatDate }}</span>
                                            </td>
                                            <td class="tw-px-4 tw-py-2"><a
                                                    v-on:click="$emit('encaissement_display',record)"
                                                    class="tw-inline-block tw-mr-3 tw-text-green-500"
                                                >
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </a></td>
                                        </tr>

                                    </tbody>
                                </table>

                            </template>

                            <div
                                v-else
                                class="tw-flex tw-flex-wrap tw-p-4 border-b tw-border-dashed tw-border-gray-400 tw-text-gray-700"
                            >
                                Aucune donnée disponible
                            </div>

                        </div>

                    </search-results>

                    <!--/ RESULTS -->


                    <!-- PAGINATION -->

                    <search-pagination group="encaissement-search" :always-show="true"></search-pagination>

                    <!--/ PAGINATION -->

                </div>

            </div>
        </div>

        <encaissements-show></encaissements-show>

    </section>

@endsection
