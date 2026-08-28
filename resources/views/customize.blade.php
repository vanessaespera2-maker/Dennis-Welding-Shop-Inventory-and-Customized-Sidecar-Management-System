<x-app-layout :title="'Customize Your Sidecar'">
    @php
        $preselectedId = $preselected?->id;
    @endphp
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-extrabold text-white">Customize Your Sidecar</h1>
        <p class="mt-2 text-gray-400">Build your dream sidecar in three easy steps. Your price estimate updates as you go.</p>

        @auth
            <div class="mt-6 rounded-lg bg-emerald-500/10 border border-emerald-500/30 px-4 py-3 text-sm text-emerald-300">
                You are logged in as <strong>{{ auth()->user()->name }}</strong>. Your request will be submitted under your account.
            </div>
        @else
            <div class="mt-6 rounded-lg bg-amber-500/10 border border-amber-500/30 px-4 py-3 text-sm text-amber-300">
                You'll need an account to submit your request. <a href="{{ route('login') }}" class="font-semibold underline">Log in</a> or <a href="{{ route('register') }}" class="font-semibold underline">create an account</a> before submitting.
            </div>
        @endauth

        <form method="POST" action="{{ route('customize.store') }}" enctype="multipart/form-data" x-data="customizer(@json($sidecars), @json($materials), @json($colors), @json($accessories), {{ $preselectedId ?? 'null' }})" class="mt-8">
            @csrf

            <div class="flex items-center gap-2 mb-8">
                <template x-for="(stepName, i) in ['Sidecar', 'Options', 'Details']" :key="i">
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-2" :class="i === 0 ? '' : 'ml-2'">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full text-sm font-bold" :class="step >= i ? 'bg-amber-500 text-gray-950' : 'bg-gray-800 text-gray-500'" x-text="i + 1"></span>
                            <span class="text-sm font-medium hidden sm:block" :class="step >= i ? 'text-white' : 'text-gray-500'" x-text="stepName"></span>
                        </div>
                        <template x-if="i < 2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-600"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                        </template>
                    </div>
                </template>
            </div>

            @error('sidecar_id')
                <div class="mb-4 rounded-lg bg-rose-500/10 border border-rose-500/30 px-4 py-3 text-sm text-rose-300">{{ $message }}</div>
            @enderror

            {{-- Step 1: Sidecar --}}
            <section x-show="step === 0" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="sidecar in sidecars" :key="sidecar.id">
                    <label class="cursor-pointer rounded-xl border bg-gray-900 p-5 transition" :class="sidecarId == sidecar.id ? 'border-amber-500 ring-2 ring-amber-500/30' : 'border-gray-800 hover:border-gray-600'">
                        <input type="radio" name="sidecar_id" :value="sidecar.id" x-model="sidecarId" class="sr-only">
                        <p class="text-xs font-semibold text-amber-400 uppercase tracking-wider" x-text="sidecar.category_name || 'Sidecar'"></p>
                        <h3 class="mt-1 font-semibold text-white" x-text="sidecar.name"></h3>
                        <p class="mt-2 text-sm text-gray-400 line-clamp-2" x-text="sidecar.description"></p>
                        <p class="mt-3 font-bold text-amber-400" x-text="'₱' + format(sidecar.base_price)"></p>
                    </label>
                </template>
            </section>

            {{-- Step 2: Options --}}
            <section x-show="step === 1" x-transition class="space-y-10">
                <div>
                    <h2 class="text-lg font-semibold text-white">Choose a Material</h2>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <template x-for="material in materials" :key="material.id">
                            <label class="cursor-pointer rounded-xl border bg-gray-900 p-4 transition" :class="materialId == material.id ? 'border-amber-500 ring-2 ring-amber-500/30' : 'border-gray-800 hover:border-gray-600'">
                                <input type="radio" name="material_id" :value="material.id" x-model="materialId" class="sr-only">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-white" x-text="material.name"></span>
                                    <span class="text-sm font-bold text-amber-400" x-text="'+₱' + format(material.additional_price)"></span>
                                </div>
                                <p class="mt-1 text-sm text-gray-400 line-clamp-2" x-text="material.description"></p>
                            </label>
                        </template>
                        <label class="cursor-pointer rounded-xl border bg-gray-900 p-4 transition" :class="materialId === null ? 'border-amber-500 ring-2 ring-amber-500/30' : 'border-gray-800 hover:border-gray-600'">
                            <input type="radio" name="material_id" value="" x-model="materialId" class="sr-only">
                            <span class="font-semibold text-white">No material upgrade</span>
                            <p class="mt-1 text-sm text-gray-400">Keep the default material (included in base price).</p>
                        </label>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-white">Choose a Color</h2>
                    <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                        <template x-for="color in colors" :key="color.id">
                            <label class="cursor-pointer rounded-xl border bg-gray-900 p-3 text-center transition" :class="colorId == color.id ? 'border-amber-500 ring-2 ring-amber-500/30' : 'border-gray-800 hover:border-gray-600'">
                                <input type="radio" name="color_id" :value="color.id" x-model="colorId" class="sr-only">
                                <span class="mx-auto block h-8 w-8 rounded-full border border-gray-700" :style="'background-color: ' + (color.color_code || '#cccccc')"></span>
                                <span class="mt-2 block text-sm font-medium text-white" x-text="color.name"></span>
                                <span class="block text-xs text-amber-400" x-text="color.additional_price > 0 ? '+₱' + format(color.additional_price) : 'Free'"></span>
                            </label>
                        </template>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-white">Add Accessories</h2>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <template x-for="accessory in accessories" :key="accessory.id">
                            <label class="cursor-pointer rounded-xl border bg-gray-900 p-4 transition" :class="selectedAccessories.includes(accessory.id) ? 'border-amber-500 ring-2 ring-amber-500/30' : 'border-gray-800 hover:border-gray-600'">
                                <input type="checkbox" name="accessories[]" :value="accessory.id" x-model="selectedAccessories" class="sr-only">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-white" x-text="accessory.name"></span>
                                    <span class="text-sm font-bold text-amber-400" x-text="'₱' + format(accessory.price)"></span>
                                </div>
                                <p class="mt-1 text-sm text-gray-400 line-clamp-2" x-text="accessory.description"></p>
                            </label>
                        </template>
                    </div>
                </div>
            </section>

            {{-- Step 3: Details --}}
            <section x-show="step === 2" x-transition class="space-y-5 max-w-3xl">
                <div>
                    <label class="text-sm font-medium text-white">Preferred Dimensions</label>
                    <input type="text" name="preferred_dimensions" placeholder="e.g. 120cm x 60cm" class="mt-1 w-full rounded-lg bg-gray-900 border border-gray-800 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-amber-500 focus:outline-none">
                </div>
                <div>
                    <label class="text-sm font-medium text-white">Special Instructions</label>
                    <textarea name="special_instructions" rows="3" placeholder="Any special requirements for the build..." class="mt-1 w-full rounded-lg bg-gray-900 border border-gray-800 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-amber-500 focus:outline-none"></textarea>
                </div>
                <div>
                    <label class="text-sm font-medium text-white">Design Notes</label>
                    <textarea name="design_notes" rows="4" placeholder="Describe your desired design, layout, or measurements..." class="mt-1 w-full rounded-lg bg-gray-900 border border-gray-800 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-amber-500 focus:outline-none"></textarea>
                </div>
                <div>
                    <label class="text-sm font-medium text-white">Upload a Design Reference (optional)</label>
                    <input type="file" name="design_image" accept="image/*" class="mt-1 block w-full text-sm text-gray-400 file:mr-4 file:rounded-lg file:border-0 file:bg-gray-800 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-gray-700">
                </div>
            </section>

            {{-- Summary + nav --}}
            <div class="mt-10 rounded-xl border border-gray-800 bg-gray-900 p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-400">Estimated Price</p>
                    <p class="text-3xl font-extrabold text-amber-400" x-text="'₱' + format(total())"></p>
                    <p class="text-xs text-gray-500 mt-1">Final price may be adjusted after review by our team.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" x-show="step > 0" x-on:click="step--" class="rounded-lg bg-gray-800 px-6 py-3 font-semibold text-white hover:bg-gray-700 transition">Back</button>
                    <button type="button" x-show="step < 2" x-on:click="next()" class="rounded-lg bg-amber-500 px-6 py-3 font-semibold text-gray-950 hover:bg-amber-400 transition">Continue</button>
                    <button type="submit" x-show="step === 2" :disabled="! sidecarId" class="rounded-lg bg-emerald-500 px-6 py-3 font-semibold text-gray-950 hover:bg-emerald-400 transition disabled:opacity-50">
                        @auth Submit Request @else Submit Request @endauth
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function customizer(sidecars, materials, colors, accessories, preselectedId) {
            const sidecarOptions = sidecars.map(s => ({
                id: s.id,
                name: s.name,
                description: s.description,
                base_price: parseFloat(s.base_price),
                category_name: s.category_name || '',
            }));
            const materialOptions = materials.map(m => ({
                id: m.id,
                name: m.name,
                description: m.description,
                additional_price: parseFloat(m.additional_price),
            }));
            const colorOptions = colors.map(c => ({
                id: c.id,
                name: c.name,
                color_code: c.color_code,
                additional_price: parseFloat(c.additional_price),
            }));
            const accessoryOptions = accessories.map(a => ({
                id: a.id,
                name: a.name,
                description: a.description,
                price: parseFloat(a.price),
            }));

            return {
                step: 0,
                sidecars: sidecarOptions,
                materials: materialOptions,
                colors: colorOptions,
                accessories: accessoryOptions,
                sidecarId: preselectedId,
                materialId: null,
                colorId: null,
                selectedAccessories: [],
                format(n) {
                    return Number(n || 0).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                },
                total() {
                    let t = 0;
                    const sidecar = this.sidecars.find(s => s.id == this.sidecarId);
                    if (sidecar) t += sidecar.base_price;
                    const material = this.materials.find(m => m.id == this.materialId);
                    if (material) t += material.additional_price;
                    const color = this.colors.find(c => c.id == this.colorId);
                    if (color) t += color.additional_price;
                    this.selectedAccessories.forEach(id => {
                        const acc = this.accessories.find(a => a.id == id);
                        if (acc) t += acc.price;
                    });
                    return t;
                },
                next() {
                    if (this.step === 0 && !this.sidecarId) {
                        alert('Please select a sidecar first.');
                        return;
                    }
                    this.step++;
                },
            };
        }
    </script>
</x-app-layout>
