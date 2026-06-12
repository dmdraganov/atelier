<x-layouts.app title="Новый заказ">
    <section class="border-b border-slate-200 pb-9 pt-4">
        <h1 class="m-0 text-[clamp(40px,6vw,72px)] font-semibold leading-[.96]">Новый заказ</h1>
        <p class="mt-5 max-w-[760px] text-lg leading-8 text-slate-600">Заполните параметры изделия. Итоговую стоимость администратор сможет уточнить после проверки.</p>
    </section>

    <form class="mt-8 grid grid-cols-[minmax(0,1fr)_340px] items-start gap-6 max-[880px]:grid-cols-1" method="post" action="{{ route('orders.store') }}" enctype="multipart/form-data" data-price-form>
        @csrf
        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-950/[.03]">
            <h2 class="mb-5 mt-0 text-2xl font-semibold">Основная информация</h2>
            <div class="grid grid-cols-2 gap-4 max-[880px]:grid-cols-1">
                <label class="grid gap-2 text-sm font-semibold text-slate-700">
                    <span>Модель</span>
                    <select class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="clothing_model_id" required data-model>
                        @foreach ($models as $model)
                            <option
                                value="{{ $model->id }}"
                                data-price="{{ $model->base_price }}"
                                @selected((int) old('clothing_model_id', request('model')) === $model->id)
                            >{{ $model->name }} — <x-price :value="$model->base_price" /></option>
                        @endforeach
                    </select>
                </label>
                <label class="grid gap-2 text-sm font-semibold text-slate-700">
                    <span>Количество</span>
                    <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="quantity" type="number" min="1" max="20" value="{{ old('quantity', 1) }}" required data-quantity>
                </label>
            </div>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-950/[.03]">
            <h2 class="mb-5 mt-0 text-2xl font-semibold">Материал и параметры</h2>
            <div class="grid grid-cols-2 gap-4 max-[880px]:grid-cols-1">
                <label class="grid gap-2 text-sm font-semibold text-slate-700">
                    <span>Материал</span>
                    <select class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="material_id" required data-material>
                        @foreach ($materials as $material)
                            <option value="{{ $material->id }}" data-price="{{ $material->price_modifier }}" @selected((int) old('material_id') === $material->id)>
                                {{ $material->name }} (+<x-price :value="$material->price_modifier" />)
                            </option>
                        @endforeach
                    </select>
                </label>
                <label class="grid gap-2 text-sm font-semibold text-slate-700">
                    <span>Сложность</span>
                    <select class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="complexity" required data-complexity>
                        @foreach ($complexities as $complexity)
                            <option value="{{ $complexity->value }}" data-multiplier="{{ $complexity->multiplier() }}" @selected(old('complexity', 'medium') === $complexity->value)>
                                {{ $complexity->label() }}
                            </option>
                        @endforeach
                    </select>
                </label>
                <label class="grid gap-2 text-sm font-semibold text-slate-700">
                    <span>Срочность</span>
                    <select class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="urgency" required data-urgency>
                        @foreach ($urgencies as $urgency)
                            <option value="{{ $urgency->value }}" data-multiplier="{{ $urgency->multiplier() }}" @selected(old('urgency', 'standard') === $urgency->value)>
                                {{ $urgency->label() }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="mt-4 grid gap-2.5">
                <h3 class="m-0 text-base font-semibold">Дополнительные параметры</h3>
                @for ($i = 0; $i < 3; $i++)
                    <div class="grid grid-cols-2 gap-2.5 max-[560px]:grid-cols-1">
                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="parameters[{{ $i }}][key]" placeholder="Параметр" value="{{ old("parameters.$i.key") }}">
                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="parameters[{{ $i }}][value]" placeholder="Значение" value="{{ old("parameters.$i.value") }}">
                    </div>
                @endfor
            </div>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-950/[.03]">
            <h2 class="mb-5 mt-0 text-2xl font-semibold">Мерки</h2>
            <div class="mt-4 grid gap-2.5">
                @foreach (['Рост', 'Обхват груди', 'Обхват талии', 'Обхват бедер', 'Длина изделия'] as $i => $name)
                    <div class="grid grid-cols-2 gap-2.5 max-[560px]:grid-cols-1">
                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="measurements[{{ $i }}][key]" value="{{ old("measurements.$i.key", $name) }}">
                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="measurements[{{ $i }}][value]" placeholder="Значение" value="{{ old("measurements.$i.value") }}">
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-950/[.03]">
            <h2 class="mb-5 mt-0 text-2xl font-semibold">Референсы и комментарий</h2>
            <label class="grid gap-2 text-sm font-semibold text-slate-700">
                <span>Изображения</span>
                <input class="w-full rounded-lg border border-dashed border-slate-300 bg-slate-50 px-3.5 py-4 text-base text-slate-950 outline-none transition file:mr-4 file:rounded-lg file:border-0 file:bg-slate-950 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="reference_images[]" type="file" accept=".jpg,.jpeg,.png,.webp" multiple data-preview-input>
            </label>
            <div class="mb-5 flex flex-wrap gap-2.5 [&>span]:rounded-full [&>span]:border [&>span]:border-slate-200 [&>span]:bg-white [&>span]:px-3 [&>span]:py-2 [&>span]:text-sm [&>span]:text-slate-600" data-preview-list></div>
            <label class="grid gap-2 text-sm font-semibold text-slate-700">
                <span>Комментарий</span>
                <textarea class="w-full resize-y rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="customer_comment" rows="5">{{ old('customer_comment') }}</textarea>
            </label>
        </section>

        <aside class="sticky top-24 grid gap-4 rounded-lg border border-slate-200 bg-slate-950 p-6 text-white shadow-xl shadow-slate-950/15 max-[880px]:static">
            <span class="text-sm font-medium text-slate-300">Предварительная стоимость</span>
            <strong class="text-4xl" data-estimate>0 ₽</strong>
            <small class="leading-6 text-slate-300">Расчёт будет повторен на сервере при создании заказа.</small>
            <button class="inline-flex min-h-12 cursor-pointer items-center justify-center rounded-lg border border-amber-400 bg-amber-400 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-amber-300" type="submit">Отправить заказ</button>
        </aside>
    </form>
</x-layouts.app>
