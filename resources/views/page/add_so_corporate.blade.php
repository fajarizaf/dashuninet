@extends('layouts.console')
@section('container')

<!-- Vue.js CDN -->
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<div class="page-body bg-white" id="app">
    <div class="container-xl">
        <div class="page-wrapper">
            <div class="page-body">

                <form @submit.prevent="onSubmit">
                    <div class="mb-3 box-select-company">

                        <label class="form-label">Company Name</label>
                        <select v-model="form.company_id" @change="onCompanyChange" name="company_id"
                            data-placeholder="Select Company..." class="form-select chosen-select customer_company"
                            id="select-company" tabindex="1" required>
                            <option value="">-- Select Company --</option>
                            @forelse($customer_company as $company)
                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="mb-3 pic">

                        <label class="form-label">PIC ( Personal In Charge )</label>
                        <select v-model="form.personal_in_charge" name="personal_in_charge"
                            data-placeholder="Select Company..." class="form-select chosen-select personal_in_charge"
                            id="select-company" tabindex="2" required>
                            <option value="">-- Select PIC --</option>
                            <option v-for="(pic, i) in picList" :key="i" :value="pic.id">
                                @{{ pic.customer_name }}
                            </option>
                        </select>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Reference</label>
                        <select v-model="form.reference_id" class="form-select" name="reference_id">
                            <option value="">-- Select --</option>

                            @forelse($site_employee as $em)
                                <option value="{{ $em->id }}">{{ $em->name }}
                                @empty
                                <option value="">No Employee Found</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company Product</label>
                        <select v-model="selectedCompanyProduct" @change="onCompanyProductChange" class="form-select"
                            required>
                            <option value="" disabled>-- Select --</option>
                            <option v-for="(produk, index) in companyProductList" :key="index" :value="produk.id">
                                @{{ produk.name }}
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Product</label>

                        <template v-for="(produk, index) in itemList" :key="index">
                            <!-- @{{ produk.nama }} - Rp @{{ produk.harga }} -->
                            <div class="accordion accordionExample mb-2" :id="`accordion-${index + 1}`">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            :data-bs-target="`#id-${index + 1}`" aria-expanded="true"
                                            :aria-controls="`id-${index + 1}`">
                                            @{{ produk.productGroupLabel }} - @{{ produk.productNameLabel }} -
                                            @{{ produk.billingCycle }}- @{{ numberWithCommas(produk.price) }}
                                        </button>
                                    </h2>
                                    <div :id="`id-${index + 1}`" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <table class="table table-transparent border bg-light mb-3">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10rem;">Product Group</th>
                                                        <th style="">Product Name</th>
                                                        <th class="">Billing Cycle</th>
                                                        <th class="text-end">@Price (IDR)</th>
                                                        <th class="text-end">@Setup Fee (IDR)</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody_clone">

                                                    <tr class="tr_clone">
                                                        <td class="py-2 text-nowrap">
                                                            <!-- <select name="group[]" class="form-select getProduct" required>
                                                    </select> -->
                                                            <select @change="onProductGroupChange($event, index)"
                                                                v-model="produk.productGroup" class="form-select"
                                                                required>
                                                                <!-- <option value="" disabled>--Pilih--</option> -->
                                                                <option v-for="(produk, index) in productGroupList"
                                                                    :key="index" :value="produk.id">
                                                                    @{{ produk.product_group_name }}
                                                                </option>
                                                            </select>

                                                        </td>
                                                        <td class="py-2">
                                                            <!-- <select name="product_id[]" class="form-select product" required>
                                                    </select> -->
                                                            <select @change="onProductChange($event, index)"
                                                                v-model="produk.product" class="form-select" required>
                                                                <!-- <option value="" disabled>--Pilih--</option> -->
                                                                <option v-for="(produk, index) in productList[index]"
                                                                    :key="index" :value="produk.id">
                                                                    @{{ produk.product_name }}
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td class="py-2">
                                                            <!-- <select name="billing_cycle[]" class="form-select billing_cycle"
                                                            required>
                                                        </select> -->
                                                            <select @change="onBillingChange($event, index)"
                                                                v-model="produk.billingCycle" class="form-select"
                                                                required>
                                                                <!-- <option value="" disabled>--Pilih--</option> -->
                                                                <option v-for="(it, index) in billingList[index]"
                                                                    :key="index" :value="it.billing_cycle">
                                                                    @{{ it.billing_cycle }}
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td class="py-2">
                                                            <input v-model="produk.price" type="number"
                                                                class="form-control text-end price" name="price[]"
                                                                value="" required />
                                                        </td>
                                                        <td class="py-2 text-end d-flex align-items-center gap-1">
                                                            <input type="hidden" class="form-control text-center"
                                                                name="qty[]" value="1" required />
                                                            <input v-model="produk.setupFee" type="number"
                                                                class="form-control text-end setup_fee"
                                                                name="setup_fee[]" value="" required />
                                                            <div class="badge text-red border border-red remove_row p-1"
                                                                title="Remove" style="cursor: pointer;display:none;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M18 6l-12 12" />
                                                                    <path d="M6 6l12 12" /></svg>&nbsp;
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>

                                            <template v-for="(data, i) in produk.fieldList" :key="i">
                                                <div class="mb-3"><label class="form-label">
                                                        @{{ data['field_name'] }}
                                                    </label>
                                                    <input required type="text" v-model="data.description"
                                                        class="form-control" data-mask-visible="true"
                                                        :placeholder="`input ${data.field_name}`" autocomplete="off">
                                                </div>
                                            </template>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="mb-7">
                            <input @click="addProduct" type="button"
                                class="btn btn-outline-cyan add_row text-capitalize float-end py-1 px-2 m-2"
                                value="add" />
                        </div>


                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sales Order Project (Area coverage)</label>
                        <select v-model="form.project_id" class="form-select" name="project_id" id="project_so"
                            aria-label="">
                            <option value="">-- Select --</option>

                            @forelse($site_project as $proj)
                                <option value="{{ $proj->id }}">{{ $proj->project_name }}
                                @empty
                                <option value="">No Project Found</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Date Order</label>
                                <input v-model="form.date_order" type="date" class="form-control" name="date_order"
                                    required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Network Availability</label>
                                <select v-model="form.network" class="form-select" name="network" required>
                                    <option>-- Select --</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">

                        <label class="form-label">Promo</label>
                        <select v-model="form.promo" name="promo" class="form-select">
                        </select>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Order Notes</label>
                        <textarea v-model="form.order_notes" class="form-control" name="order_notes"
                            placeholder="describe related order information" value="" required></textarea>
                    </div>

                    <div class="mb-7">
                        <input type="submit" class="btn btn-primary float-end m-2" value="Create" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    const {
        createApp
    } = Vue;

    createApp({
        data() {
            return {
                form: {
                    company_id: "",
                    personal_in_charge: "",
                    reference_id: "",
                    project_id: "",
                    date_order: "",
                    network: "",
                    promo: "",
                    order_notes: "",
                },
                selectedCompanyProduct: '',
                // selectedProductGroup: '',
                // selectedProduct: '',
                companyProductList: [{
                        name: "UMS",
                        id: "UMS"
                    },
                    {
                        name: "UMI",
                        id: "UMI"
                    },
                    {
                        name: "UMTEL",
                        id: "UMTEL"
                    },
                ],
                picList: [],
                productGroupList: [],
                productList: [],
                billingList: [],
                productGroupLabel: "",
                itemList: [{
                    fieldList: [],
                    productGroup: "",
                    product: "",
                    billingCycle: "",
                    price: "",
                    setupFee: "",
                    productGroupLabel: "",
                    productNameLabel: ""
                }],
                newProduct: {
                    fieldList: [],
                    productGroup: "",
                    product: "",
                    billingCycle: "",
                    price: "",
                    setupFee: "",
                    productGroupLabel: "",
                    productNameLabel: ""
                }
            };
        },
        methods: {
            async onCompanyChange(event) {
                try {
                    const response = await axios.get(
                        "{{ route('pic_corporate_list') }}", {
                            params: {
                                company_id: event.target.value
                            }
                        });

                    this.picList = response.data;
                } catch (error) {
                    console.error("Gagal mengambil data:", error);
                }
            },
            async onCompanyProductChange() {
                try {
                    const response = await axios.post(
                        "{{ route('get_product_group') }}", {
                            product_group_headline: this.selectedCompanyProduct
                        });
                    this.productGroupList = response.data;
                    this.itemList = [{
                        fieldList: [],
                        productGroup: "",
                        product: "",
                        billingCycle: "",
                        price: "",
                        setupFee: "",
                        productGroupLabel: "",
                        productNameLabel: ""
                    }];
                    this.productList = []
                    this.billingList = []

                } catch (error) {
                    console.error("Gagal mengambil data:", error);
                }
            },
            async onProductGroupChange(event, index) {
                console.log(event.target.options[event.target
                    .selectedIndex].text)
                this.itemList[index].productGroupLabel = event.target.options[event.target.selectedIndex]
                    .text;
                try {
                    const response = await axios.post(
                        "{{ route('get_product_plan') }}", {
                            group_id: event.target.value
                        });

                    this.productList[index] = response.data;
                } catch (error) {
                    console.error("Gagal mengambil data:", error);
                }
            },
            async onProductChange(event, index) {
                this.itemList[index].productNameLabel = event.target.options[event.target.selectedIndex]
                    .text;
                try {
                    const response = await axios.post(
                        "{{ route('get_billing_cycle') }}", {
                            product_id: event.target.value
                        });

                    this.billingList[index] = response.data;

                    const res_field = await axios.post(
                        "{{ route('get_product_field') }}", {
                            product_id: event.target.value
                        });

                    if (res_field.data.length != 0) {
                        this.itemList[index].fieldList = res_field.data
                    } else {

                    }

                } catch (error) {
                    console.error("Gagal mengambil data:", error);
                }
            },
            async onBillingChange(event, index) {
                try {
                    const response = await axios.post(
                        "{{ route('get_billing_price') }}", {
                            billing_id: event.target.value,
                            product_id: this.itemList[index].product
                        });

                    this.itemList[index].price = response.data.price;
                    this.itemList[index].setupFee = response.data.setup_fee;
                } catch (error) {
                    console.error("Gagal mengambil data:", error);
                }
            },
            addProduct() {
                // if (!this.newProduct.nama || !this.newProduct.harga) return;

                this.itemList.push({
                    ...this.newProduct,
                    // id: this.itemList.length + 1
                });
                // this.newProduct = {
                //     nama: "",
                //     harga: ""
                // };
                // console.log(response.data.message);
            },
            async onSubmit() {
                try {
                    const response = await axios.post(
                        "{{ route('create_corporate') }}", {
                            form: this.form,
                            item: this.itemList
                        }
                    );
                    console.log(response)
                    alert('Sales Order berhasil dibuat');
                    window.location.href = '/console/salesorder';

                } catch (error) {
                    console.error("Gagal submit data:", error);
                }
            },
            numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            },
        }
    }).mount("#app");

</script>

@endsection
