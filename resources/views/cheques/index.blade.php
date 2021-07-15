@extends('app')

@section('app_content')

    <section class="section">

        <div class="container">

            <div class="tw-bg-white tw-shadow-md tw-rounded tw-px-3 md:tw-px-8 tw-pt-3 md:tw-pt-6 tw-pb-3 md:tw-pb-8 tw-mb-4">

                <div class="tw-mb-4">

                    <h2 class="tw-text-blue-600 tw-text-lg tw-font-bold tw-mb-3 tw-border-b tw-border-gray-400 tw-pb-2">Liste des Chèques</h2>

                    <!-- SEARCH FORM -->

                    <search-form
                        group="cheque-search"
                        url="{{ route('cheques.fetch') }}"
                        :params="{
                            search: '',
                            per_page: {{ $defaultPerPage }},
                            page: 1,
                            order_by: 'ACC_CODE:asc',
                            createdat_du: '',
                            createdat_au: '',
                            type: '',
                            statut: '',
                            etatrappro: '',
                            agence: '',
                            }"
                        v-slot="{ params, update, change, clear, processing }"
                    >

                        <form class="tw-grid tw-grid-cols-10 tw-col-gap-4 tw-pb-3 tw-border-b tw-border-gray-400">
                            <div class="tw-col-span-4 md:tw-col-span-2">
                                <label
                                    for="createdat_du"
                                    class="tw-block tw-uppercase tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2"
                                >
                                    Du
                                </label>
                                <div class="relative">
                                    <vue2-datepicker id="createdat_du" lang="fr" style="width: 90%; height: 90%;" v-model="params.createdat_du" format="YYYY-MM-DD" @change="change"></vue2-datepicker>
                                </div>
                            </div>

                            <div class="tw-col-span-4 md:tw-col-span-2">
                                <label
                                    for="createdat_au"
                                    class="tw-block tw-uppercase tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2"
                                >
                                    Au
                                </label>
                                <div class="relative">
                                    <vue2-datepicker id="createdat_au" lang="fr" style="width: 90%; height: 90%;" v-model="params.createdat_au" format="YYYY-MM-DD" @change="change"></vue2-datepicker>
                                </div>
                            </div>

                            {{--                            TODO: PB de rafraichissement des parametres de filtre--}}

                            <div class="tw-col-span-4 md:tw-col-span-2">
                                <label
                                    for="etatrappro"
                                    class="tw-block tw-uppercase tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2"
                                >
                                    Etat Rapprochement
                                </label>
                                <div class="tw-inline-flex">
                                    <div class="tw-relative">
                                        <select
                                            v-model="params.etatrappro"
                                            @change="change"
                                            id="etatrappro"
                                            class="tw-appearance-none tw-block tw-w-full tw-bg-gray-200 focus:tw-bg-white tw-text-gray-700 tw-text-xs tw-border tw-border-gray-400 focus:tw-border-gray-500 tw-rounded-sm tw-py-3 tw-pl-4 tw-pr-8 tw-leading-tight focus:tw-outline-none"
                                        >
                                            <option
                                                v-for="etatrappro in {{ $etatrappros }}"
                                                :value="etatrappro.code"
                                            >@{{ etatrappro.name }}</option>
                                        </select>
                                        <select-angle></select-angle>
                                    </div>
                                    <div class="input-group-append">
                                        <button type="button" id="etatrappro_clear" name="etatrappro_clear" class="btn btn-default btn-sm" @click="[params.etatrappro= '', change()]"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="tw-col-span-4 md:tw-col-span-2">
                                <label
                                    for="agence"
                                    class="tw-block tw-uppercase tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2"
                                >
                                    Agence
                                </label>
                                <div class="tw-inline-flex">
                                    <div class="tw-relative">
                                        <select
                                            v-model="params.agence"
                                            @change="change"
                                            id="agence"
                                            class="tw-appearance-none tw-block tw-w-full tw-bg-gray-200 focus:tw-bg-white tw-text-gray-700 tw-text-xs tw-border tw-border-gray-400 focus:tw-border-gray-500 tw-rounded-sm tw-py-3 tw-pl-4 tw-pr-8 tw-leading-tight focus:tw-outline-none"
                                        >
                                            <option
                                                v-for="agence in {{ $agences }}"
                                                :value="agence.id"
                                            >@{{ agence.LocationName }}</option>
                                        </select>
                                        <select-angle></select-angle>
                                    </div>
                                    <div class="input-group-append">
                                        <button type="button" id="agence_clear" name="agence_clear" class="btn btn-default btn-sm" @click="[params.agence= '', change()]"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="tw-col-span-4 md:tw-col-span-2">
                                <label
                                    for="statut"
                                    class="tw-block tw-uppercase tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2"
                                >
                                    Statut
                                </label>
                                <div class="tw-inline-flex">
                                    <div class="tw-relative">
                                        <select
                                            v-model="params.statut"
                                            @change="change"
                                            id="statut"
                                            class="tw-appearance-none tw-block tw-w-full tw-bg-gray-200 focus:tw-bg-white tw-text-gray-700 tw-text-xs tw-border tw-border-gray-400 focus:tw-border-gray-500 tw-rounded-sm tw-py-3 tw-pl-4 tw-pr-8 tw-leading-tight focus:tw-outline-none"
                                        >
                                            <option
                                                v-for="statut in {{ $statuts }}"
                                                :value="statut.id"
                                            >@{{ statut.titre }}</option>
                                        </select>
                                        <select-angle></select-angle>
                                    </div>
                                    <div class="input-group-append">
                                        <button type="button" id="statut_clear" name="statut_clear" class="btn btn-default btn-sm" @click="[params.statut= '', change()]"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </search-form>

                    <!--/ SEARCH FORM -->


                    <!-- RESULTS -->

                    <search-results group="cheque-search" v-slot="{ total, records }">

                        <div class="tw-text-sm">

                            <div class="tw-flex tw-flex-wrap tw-p-4 tw-bg-gray-700 tw-text-white tw-rounded-sm">
                                <div class="tw-flex-auto tw-pr-3">Total : @{{ total }}</div>
                            </div>

                            <template v-if="records.length">

                                <table class="table-auto">
                                    <thead>
                                    <tr>
                                        <th class="tw-px-4 tw-py-2">Enregistrement</th>
                                        <th class="tw-px-4 tw-py-2">Code Compte</th>
                                        <th class="tw-px-4 tw-py-2">Numéro Chèque</th>
                                        <th class="tw-px-4 tw-py-2">Descriptoion</th>
                                        <th class="tw-px-4 tw-py-2">Montant Banque</th>
                                        <th class="tw-px-4 tw-py-2">Localité</th>
                                        <th class="tw-px-4 tw-py-2">Montant</th>
                                        <th class="tw-px-4 tw-py-2">Statut</th>
                                        <th class="tw-px-4 tw-py-2">Détails</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="record in records"
                                        :key="record.id"
                                        class="tw-px-4 tw-border-b tw-border-dashed tw-border-gray-400 tw-text-gray-700 hover:tw-bg-gray-100"
                                    >
                                        <td class="tw-px-4 tw-py-2">
                                            <span class="tw-text-sm">@{{ record.id }}</span>
                                        </td>
                                        <td class="tw-px-4 tw-py-2">
                                            <span class="tw-text-sm">@{{ record.ACC_CODE }}</span>
                                        </td>
                                        <td class="tw-px-4 tw-py-2">
                                            <span class="tw-text-sm">@{{ record.CHEQUE_NB }}</span>
                                        </td>
                                        <td class="tw-px-4 tw-py-2">
                                            <span class="tw-text-sm tw-w-36">@{{ record.DESCRIPTION }}</span>
                                        </td>
                                        <td class="tw-px-4 tw-py-2">
                                            <span class="tw-text-sm">@{{ record.TRN_AMOUNT | formatNumber }}</span>
                                        </td>
                                        <td class="tw-px-4 tw-py-2">
                                            <span class="tw-text-sm" v-if="record.encaissement">
                                                @{{ record.encaissement.agence.LocationName }}
                                            </span>
                                        </td>
                                        <td class="tw-px-4 tw-py-2">
                                            <span class="tw-text-sm" v-if="record.encaissement">
                                                @{{ record.encaissement.Initial_TotalAmountPaid }}
                                            </span>
                                        </td>
                                        <td class="tw-px-6 tw-py-2">
                                            <span v-if="record.workflowexec.currentstep.code == 'step_end'" class="tw-text-xs tw-font-semibold tw-inline-block tw-py-1 tw-px-2 tw-rounded tw-text-green-600 tw-bg-green-200 tw-w-32 last:tw-mr-0 tw-mr-1">@{{ record.workflowexec.currentstep.titre }}</span>
                                            <span v-else-if="record.workflowexec.currentstep.code == 'step_0'" class="tw-text-xs tw-font-semibold tw-inline-block tw-py-1 tw-px-2 tw-rounded tw-text-purple-600 tw-bg-purple-200 tw-w-32 last:tw-mr-0 tw-mr-1">@{{ record.workflowexec.currentstep.titre }}</span>
                                            <span v-else-if="record.workflowexec.currentstep.code == 'step_1'" class="tw-text-xs tw-font-semibold tw-inline-block tw-py-1 tw-px-2 tw-rounded tw-text-indigo-600 tw-bg-indigo-200 tw-w-32 last:tw-mr-0 tw-mr-1">@{{ record.workflowexec.currentstep.titre }}</span>
                                            <span v-else-if="record.workflowexec.currentstep.code == 'step_2'" class="tw-text-xs tw-font-semibold tw-inline-block tw-py-1 tw-px-2 tw-rounded tw-text-blue-600 tw-bg-blue-200 tw-w-32 last:tw-mr-0 tw-mr-1">@{{ record.workflowexec.currentstep.titre }}</span>
                                            <span v-else class="tw-text-xs tw-font-semibold tw-inline-block tw-py-1 tw-px-2 tw-rounded tw-text-teal-600 tw-bg-red-200 tw-w-32 last:tw-mr-0 tw-mr-1">@{{ record.workflowexec.currentstep.titre }}</span>
                                        </td>
                                        <td class="tw-px-4 tw-py-2"><a
                                                :href="record.edit_url"
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

                    <search-pagination group="cheque-search" :always-show="true"></search-pagination>

                    <!--/ PAGINATION -->

                </div>

            </div>
        </div>

    </section>

@endsection
