<x-layouts.app title="Новый заказ">
    <section class="border-b border-slate-200 pb-9 pt-4">
        <span class="eyebrow">Оформление заказа</span>
        <h1 class="section-title mt-4">Новый заказ</h1>
        <p class="section-copy mt-5">Заполните параметры изделия. Предварительная стоимость обновляется на странице, но финальный расчёт всегда повторяется на сервере.</p>
    </section>

    <form class="mt-8 grid grid-cols-[minmax(0,1fr)_360px] items-start gap-6 max-[920px]:grid-cols-1" method="post" action="{{ route('orders.store') }}" enctype="multipart/form-data" data-price-form>
        @csrf

        <div class="grid gap-5">
            <section class="atelier-card p-6">
                <div class="mb-5 flex items-start justify-between gap-4 max-[640px]:flex-col">
                    <div>
                        <span class="text-sm font-extrabold text-teal-700">01</span>
                        <h2 class="mb-0 mt-2 text-2xl font-extrabold">Основная информация</h2>
                    </div>
                    <p class="m-0 max-w-[360px] text-sm leading-6 text-slate-500">Модель задаёт базовую цену, количество влияет на итоговую оценку.</p>
                </div>
                <div class="grid grid-cols-2 gap-4 max-[760px]:grid-cols-1">
                    <label class="field-label">
                        <span>Модель</span>
                        <select class="field-control" name="clothing_model_id" required data-model>
                            @foreach ($models as $model)
                                <option
                                    value="{{ $model->id }}"
                                    data-price="{{ $model->base_price }}"
                                    @selected((int) old('clothing_model_id', request('model')) === $model->id)
                                >{{ $model->name }} — <x-price :value="$model->base_price" /></option>
                            @endforeach
                        </select>
                    </label>
                    <label class="field-label">
                        <span>Количество</span>
                        <input class="field-control" name="quantity" type="number" inputmode="numeric" min="1" max="20" value="{{ old('quantity', 1) }}" required data-quantity>
                    </label>
                </div>
            </section>

            <section class="atelier-card p-6">
                <div class="mb-5 flex items-start justify-between gap-4 max-[640px]:flex-col">
                    <div>
                        <span class="text-sm font-extrabold text-teal-700">02</span>
                        <h2 class="mb-0 mt-2 text-2xl font-extrabold">Материал и параметры</h2>
                    </div>
                    <p class="m-0 max-w-[360px] text-sm leading-6 text-slate-500">Сложность и срочность меняют предварительную стоимость.</p>
                </div>
                <div class="grid grid-cols-3 gap-4 max-[920px]:grid-cols-1">
                    <label class="field-label">
                        <span>Материал</span>
                        <select class="field-control" name="material_id" required data-material>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}" data-price="{{ $material->price_modifier }}" @selected((int) old('material_id') === $material->id)>
                                    {{ $material->name }} (+<x-price :value="$material->price_modifier" />)
                                </option>
                            @endforeach
                        </select>
                    </label>
                    <label class="field-label">
                        <span>Сложность</span>
                        <select class="field-control" name="complexity" required data-complexity>
                            @foreach ($complexities as $complexity)
                                <option value="{{ $complexity->value }}" data-multiplier="{{ $complexity->multiplier() }}" @selected(old('complexity', 'medium') === $complexity->value)>
                                    {{ $complexity->label() }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                    <label class="field-label">
                        <span>Срочность</span>
                        <select class="field-control" name="urgency" required data-urgency>
                            @foreach ($urgencies as $urgency)
                                <option value="{{ $urgency->value }}" data-multiplier="{{ $urgency->multiplier() }}" @selected(old('urgency', 'standard') === $urgency->value)>
                                    {{ $urgency->label() }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="mt-5 grid gap-3">
                    <h3 class="m-0 text-base font-extrabold">Дополнительные параметры</h3>
                    @for ($i = 0; $i < 3; $i++)
                        <div class="grid grid-cols-2 gap-3 max-[640px]:grid-cols-1">
                            <input class="field-control" name="parameters[{{ $i }}][key]" placeholder="Параметр" value="{{ old("parameters.$i.key") }}">
                            <input class="field-control" name="parameters[{{ $i }}][value]" placeholder="Значение" value="{{ old("parameters.$i.value") }}">
                        </div>
                    @endfor
                </div>
            </section>

            <section class="atelier-card p-6">
                <div class="mb-5 flex items-start justify-between gap-4 max-[640px]:flex-col">
                    <div>
                        <span class="text-sm font-extrabold text-teal-700">03</span>
                        <h2 class="mb-0 mt-2 text-2xl font-extrabold">Мерки</h2>
                    </div>
                    <p class="m-0 max-w-[360px] text-sm leading-6 text-slate-500">Можно оставить пустыми поля, которые пока неизвестны.</p>
                </div>
                <div class="grid gap-3">
                    @foreach (['Рост', 'Обхват груди', 'Обхват талии', 'Обхват бедер', 'Длина изделия'] as $i => $name)
                        <div class="grid grid-cols-2 gap-3 max-[640px]:grid-cols-1">
                            <input class="field-control" name="measurements[{{ $i }}][key]" value="{{ old("measurements.$i.key", $name) }}">
                            <input class="field-control" name="measurements[{{ $i }}][value]" placeholder="Значение" value="{{ old("measurements.$i.value") }}">
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="atelier-card p-6">
                <div class="mb-5 flex items-start justify-between gap-4 max-[640px]:flex-col">
                    <div>
                        <span class="text-sm font-extrabold text-teal-700">04</span>
                        <h2 class="mb-0 mt-2 text-2xl font-extrabold">Референсы и комментарий</h2>
                    </div>
                    <p class="m-0 max-w-[360px] text-sm leading-6 text-slate-500">Загрузите изображения и добавьте пожелания по посадке, деталям или отделке.</p>
                </div>
                <label class="field-label">
                    <span>Изображения</span>
                    <input class="file-control" name="reference_images[]" type="file" accept=".jpg,.jpeg,.png,.webp" multiple data-preview-input>
                </label>
                <div class="mb-5 mt-3 flex flex-wrap gap-2.5 [&>span]:rounded-full [&>span]:border [&>span]:border-slate-200 [&>span]:bg-white [&>span]:px-3 [&>span]:py-2 [&>span]:text-sm [&>span]:font-semibold [&>span]:text-slate-600" data-preview-list></div>
                <label class="field-label">
                    <span>Комментарий</span>
                    <textarea class="field-control resize-y" name="customer_comment" rows="5">{{ old('customer_comment') }}</textarea>
                </label>
            </section>
        </div>

        <aside class="sticky top-24 grid gap-4 rounded-lg border border-slate-900 bg-slate-950 p-6 text-white shadow-2xl shadow-slate-950/20 max-[920px]:static">
            <span class="text-sm font-bold text-slate-300">Предварительная стоимость</span>
            <strong class="text-4xl font-black" data-estimate>0 ₽</strong>
            <small class="leading-6 text-slate-300">Расчёт будет повторен на сервере при создании заказа. Администратор сможет уточнить финальную цену после проверки.</small>
            <button class="btn btn-accent min-h-12" type="submit">Отправить заказ</button>
        </aside>
    </form>
</x-layouts.app>
