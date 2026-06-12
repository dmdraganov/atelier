<x-layouts.app title="Новый заказ">
    <section class="py-6">
        <h1 class="m-0 text-[clamp(34px,5vw,64px)] leading-none">Новый заказ</h1>
        <p class="max-w-[720px] text-lg leading-relaxed text-slate-600">Заполните параметры изделия. Итоговую стоимость администратор сможет уточнить после проверки.</p>
    </section>

    <form class="grid grid-cols-[minmax(0,1fr)_320px] items-start gap-4 max-[880px]:grid-cols-1" method="post" action="{{ route('orders.store') }}" enctype="multipart/form-data" data-price-form>
        @csrf
        <section class="rounded-lg border border-slate-200 bg-white p-5">
            <h2 class="mb-4 mt-0">Основная информация</h2>
            <div class="grid grid-cols-2 gap-4 max-[880px]:grid-cols-1">
                <label class="grid gap-2 font-semibold text-slate-700">
                    <span>Модель</span>
                    <select class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="clothing_model_id" required data-model>
                        @foreach ($models as $model)
                            <option
                                value="{{ $model->id }}"
                                data-price="{{ $model->base_price }}"
                                @selected((int) old('clothing_model_id', request('model')) === $model->id)
                            >{{ $model->name }} — <x-price :value="$model->base_price" /></option>
                        @endforeach
                    </select>
                </label>
                <label class="grid gap-2 font-semibold text-slate-700">
                    <span>Количество</span>
                    <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="quantity" type="number" min="1" max="20" value="{{ old('quantity', 1) }}" required data-quantity>
                </label>
            </div>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-5">
            <h2 class="mb-4 mt-0">Материал и параметры</h2>
            <div class="grid grid-cols-2 gap-4 max-[880px]:grid-cols-1">
                <label class="grid gap-2 font-semibold text-slate-700">
                    <span>Материал</span>
                    <select class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="material_id" required data-material>
                        @foreach ($materials as $material)
                            <option value="{{ $material->id }}" data-price="{{ $material->price_modifier }}" @selected((int) old('material_id') === $material->id)>
                                {{ $material->name }} (+<x-price :value="$material->price_modifier" />)
                            </option>
                        @endforeach
                    </select>
                </label>
                <label class="grid gap-2 font-semibold text-slate-700">
                    <span>Сложность</span>
                    <select class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="complexity" required data-complexity>
                        @foreach ($complexities as $complexity)
                            <option value="{{ $complexity->value }}" data-multiplier="{{ $complexity->multiplier() }}" @selected(old('complexity', 'medium') === $complexity->value)>
                                {{ $complexity->label() }}
                            </option>
                        @endforeach
                    </select>
                </label>
                <label class="grid gap-2 font-semibold text-slate-700">
                    <span>Срочность</span>
                    <select class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="urgency" required data-urgency>
                        @foreach ($urgencies as $urgency)
                            <option value="{{ $urgency->value }}" data-multiplier="{{ $urgency->multiplier() }}" @selected(old('urgency', 'standard') === $urgency->value)>
                                {{ $urgency->label() }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="mt-4 grid gap-2.5">
                <h3 class="m-0 text-base">Дополнительные параметры</h3>
                @for ($i = 0; $i < 3; $i++)
                    <div class="grid grid-cols-2 gap-2.5 max-[560px]:grid-cols-1">
                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="parameters[{{ $i }}][key]" placeholder="Параметр" value="{{ old("parameters.$i.key") }}">
                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="parameters[{{ $i }}][value]" placeholder="Значение" value="{{ old("parameters.$i.value") }}">
                    </div>
                @endfor
            </div>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-5">
            <h2 class="mb-4 mt-0">Мерки</h2>
            <div class="mt-4 grid gap-2.5">
                @foreach (['Рост', 'Обхват груди', 'Обхват талии', 'Обхват бедер', 'Длина изделия'] as $i => $name)
                    <div class="grid grid-cols-2 gap-2.5 max-[560px]:grid-cols-1">
                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="measurements[{{ $i }}][key]" value="{{ old("measurements.$i.key", $name) }}">
                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="measurements[{{ $i }}][value]" placeholder="Значение" value="{{ old("measurements.$i.value") }}">
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-5">
            <h2 class="mb-4 mt-0">Референсы и комментарий</h2>
            <label class="grid gap-2 font-semibold text-slate-700">
                <span>Изображения</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="reference_images[]" type="file" accept=".jpg,.jpeg,.png,.webp" multiple data-preview-input>
            </label>
            <div class="mb-5 flex flex-wrap gap-2.5 [&>span]:rounded-full [&>span]:border [&>span]:border-slate-200 [&>span]:bg-white [&>span]:px-3 [&>span]:py-2 [&>span]:text-sm [&>span]:text-slate-600" data-preview-list></div>
            <label class="grid gap-2 font-semibold text-slate-700">
                <span>Комментарий</span>
                <textarea class="w-full resize-y rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="customer_comment" rows="5">{{ old('customer_comment') }}</textarea>
            </label>
        </section>

        <aside class="sticky top-4 grid gap-3 rounded-lg border border-slate-200 bg-white p-5 max-[880px]:static">
            <span>Предварительная стоимость</span>
            <strong class="text-3xl" data-estimate>0 ₽</strong>
            <small>Расчёт будет повторен на сервере при создании заказа.</small>
            <button class="inline-flex min-h-10 cursor-pointer items-center justify-center rounded-lg border border-slate-900 bg-slate-900 px-4 py-2.5 font-semibold text-white" type="submit">Отправить заказ</button>
        </aside>
    </form>
</x-layouts.app>
