<x-layouts.app title="Оформить заказ">
    <section class="grid grid-cols-[minmax(0,1fr)_340px] gap-8 border-b border-[#e3d4da] pb-9 pt-4 max-[920px]:grid-cols-1">
        <div>
            <p class="section-kicker m-0">Бриф на изделие</p>
            <h1 class="section-title mt-3">Оформить заказ</h1>
            <p class="section-copy mt-5">Опишите изделие так, как рассказали бы мастеру на первой встрече: фасон, услуга, ткань, посадка, детали и референсы.</p>
        </div>
        <div class="atelier-shell self-end p-5">
            <p class="m-0 text-sm font-bold text-[#8a6875]">Что будет дальше</p>
            <p class="m-0 mt-2 leading-7 text-[#6f5b66]">После отправки администратор посмотрит бриф, уточнит финальную стоимость и назначит дальнейший статус заказа.</p>
        </div>
    </section>

    <form class="mt-8 grid grid-cols-[minmax(0,1fr)_360px] items-start gap-6 max-[920px]:grid-cols-1" method="post" action="{{ route('orders.store') }}" enctype="multipart/form-data" data-price-form>
        @csrf

        <div class="grid gap-5">
            <section class="atelier-card p-6">
                <div class="mb-5 grid grid-cols-[180px_1fr] gap-5 max-[640px]:grid-cols-1">
                    <div>
                        <span class="font-serif text-4xl font-semibold text-[#b9852f]">01</span>
                        <h2 class="mb-0 mt-2 text-2xl font-black text-[#3d1028]">Услуга</h2>
                    </div>
                    <p class="m-0 leading-7 text-[#6f5b66]">Сначала выберите формат работы. От услуги зависят доступные модели, материал, мерки и предварительная стоимость.</p>
                </div>

                <label class="field-label">
                    <span>Что нужно сделать</span>
                    <select class="field-control @error('tailoring_service_id') field-control-error @enderror" name="tailoring_service_id" required data-service>
                        @foreach ($tailoringServices as $service)
                            <option
                                value="{{ $service->id }}"
                                data-mode="{{ $service->pricing_mode->value }}"
                                data-base-price="{{ $service->base_price }}"
                                data-model-factor="{{ $service->model_price_factor }}"
                                data-requires-model="{{ $service->requires_model ? '1' : '0' }}"
                                data-requires-material="{{ $service->requires_material ? '1' : '0' }}"
                                data-requires-measurements="{{ $service->requires_measurements ? '1' : '0' }}"
                                data-applies-complexity="{{ $service->applies_complexity ? '1' : '0' }}"
                                data-applies-urgency="{{ $service->applies_urgency ? '1' : '0' }}"
                                data-applies-quantity="{{ $service->applies_quantity ? '1' : '0' }}"
                                data-model-ids="{{ $service->clothingModels->pluck('id')->implode(',') }}"
                                @selected((int) old('tailoring_service_id') === $service->id)
                            >{{ $service->name }} @if ((float) $service->base_price > 0) (от <x-price :value="$service->base_price" />) @endif</option>
                        @endforeach
                    </select>
                    <span class="field-help">Состав формы и расчёт меняются в зависимости от выбранной услуги.</span>
                    @error('tailoring_service_id')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </label>
            </section>

            <section class="atelier-card p-6">
                <div class="mb-5 grid grid-cols-[180px_1fr] gap-5 max-[640px]:grid-cols-1">
                    <div>
                        <span class="font-serif text-4xl font-semibold text-[#b9852f]">02</span>
                        <h2 class="mb-0 mt-2 text-2xl font-black text-[#3d1028]">Модель</h2>
                    </div>
                    <p class="m-0 leading-7 text-[#6f5b66]">Выберите фасон или основу, если эта услуга предполагает изделие. Список моделей подстраивается под выбранную услугу.</p>
                </div>
                <div class="grid grid-cols-[1fr_160px] gap-4 max-[760px]:grid-cols-1">
                    <label class="field-label" data-model-field>
                        <span>Модель или основа</span>
                        <select class="field-control @error('clothing_model_id') field-control-error @enderror" name="clothing_model_id" data-model>
                            @foreach ($models as $model)
                                <option
                                    value="{{ $model->id }}"
                                    data-price="{{ $model->base_price }}"
                                    @selected((int) old('clothing_model_id', request('model')) === $model->id)
                                >{{ $model->name }} — <x-price :value="$model->base_price" /></option>
                            @endforeach
                        </select>
                        @error('clothing_model_id')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="field-label" data-quantity-field>
                        <span>Количество</span>
                        <input class="field-control @error('quantity') field-control-error @enderror" name="quantity" type="number" inputmode="numeric" min="1" max="20" value="{{ old('quantity', 1) }}" required data-quantity>
                        @error('quantity')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
            </section>

            <section class="atelier-card p-6">
                <div class="mb-5 grid grid-cols-[180px_1fr] gap-5 max-[640px]:grid-cols-1">
                    <div>
                        <span class="font-serif text-4xl font-semibold text-[#b9852f]">03</span>
                        <h2 class="mb-0 mt-2 text-2xl font-black text-[#3d1028]">Материал и условия</h2>
                    </div>
                    <p class="m-0 leading-7 text-[#6f5b66]">Укажите ткань, сложность конструкции, срок и контекст задачи. Эти данные сохраняются для администратора и мастера.</p>
                </div>

                <div class="grid grid-cols-3 gap-4 max-[920px]:grid-cols-1">
                    <label class="field-label" data-material-field>
                        <span>Материал</span>
                        <select class="field-control @error('material_id') field-control-error @enderror" name="material_id" data-material>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}" data-price="{{ $material->price_modifier }}" @selected((int) old('material_id') === $material->id)>
                                    {{ $material->name }} (+<x-price :value="$material->price_modifier" />)
                                </option>
                            @endforeach
                        </select>
                        @error('material_id')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="field-label" data-complexity-field>
                        <span>Конструкция</span>
                        <select class="field-control @error('complexity') field-control-error @enderror" name="complexity" required data-complexity>
                            @foreach ($complexities as $complexity)
                                <option value="{{ $complexity->value }}" data-multiplier="{{ $complexity->multiplier() }}" @selected(old('complexity', 'medium') === $complexity->value)>
                                    {{ $complexity->label() }}
                                </option>
                            @endforeach
                        </select>
                        <span class="field-help">Чем сложнее изделие и отделка, тем выше оценка.</span>
                        @error('complexity')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="field-label" data-urgency-field>
                        <span>Срок</span>
                        <select class="field-control @error('urgency') field-control-error @enderror" name="urgency" required data-urgency>
                            @foreach ($urgencies as $urgency)
                                <option value="{{ $urgency->value }}" data-multiplier="{{ $urgency->multiplier() }}" @selected(old('urgency', 'standard') === $urgency->value)>
                                    {{ $urgency->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('urgency')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                <div class="mt-5 grid grid-cols-2 gap-4 max-[760px]:grid-cols-1">
                    <input type="hidden" name="parameters[0][key]" value="Повод">
                    <label class="field-label">
                        <span>Повод или задача</span>
                        <input class="field-control" name="parameters[0][value]" placeholder="Например: свадьба, офис, выпускной" value="{{ old('parameters.0.value') }}">
                    </label>
                    <input type="hidden" name="parameters[1][key]" value="Предпочтения по посадке">
                    <label class="field-label">
                        <span>Предпочтения по посадке</span>
                        <input class="field-control" name="parameters[1][value]" placeholder="Свободно, по фигуре, акцент на талии" value="{{ old('parameters.1.value') }}">
                    </label>
                </div>
            </section>

            <section class="atelier-card p-6">
                <div class="mb-5 grid grid-cols-[180px_1fr] gap-5 max-[640px]:grid-cols-1">
                    <div>
                        <span class="font-serif text-4xl font-semibold text-[#b9852f]">04</span>
                        <h2 class="mb-0 mt-2 text-2xl font-black text-[#3d1028]">Мерки</h2>
                    </div>
                    <p class="m-0 leading-7 text-[#6f5b66]">Если точных мерок пока нет, заполните известные значения. Остальное можно уточнить на примерке.</p>
                </div>
                <div data-measurements-field>
                    @foreach ($tailoringServices as $service)
                        <div class="grid grid-cols-2 gap-4 max-[640px]:grid-cols-1" data-measurement-group="{{ $service->id }}">
                            @forelse ($service->measurementTypes as $measurementType)
                                <label class="field-label">
                                    <span>
                                        {{ $measurementType->name }}
                                        @if ($measurementType->unit)
                                            <span class="font-semibold text-[#8a6875]">({{ $measurementType->unit }})</span>
                                        @endif
                                    </span>
                                    <input class="field-control @error('measurement_values.'.$measurementType->id) field-control-error @enderror" name="measurement_values[{{ $measurementType->id }}]" placeholder="Значение" value="{{ old('measurement_values.'.$measurementType->id) }}" @required($measurementType->is_required || $measurementType->pivot->is_required)>
                                    @if ($measurementType->help_text)
                                        <span class="field-help">{{ $measurementType->help_text }}</span>
                                    @endif
                                    @error('measurement_values.'.$measurementType->id)
                                        <span class="field-error">{{ $message }}</span>
                                    @enderror
                                </label>
                            @empty
                                <p class="m-0 leading-7 text-[#6f5b66]">Для этой услуги мерки не нужны.</p>
                            @endforelse
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="atelier-card p-6">
                <div class="mb-5 grid grid-cols-[180px_1fr] gap-5 max-[640px]:grid-cols-1">
                    <div>
                        <span class="font-serif text-4xl font-semibold text-[#b9852f]">05</span>
                        <h2 class="mb-0 mt-2 text-2xl font-black text-[#3d1028]">Детали и референсы</h2>
                    </div>
                    <p class="m-0 leading-7 text-[#6f5b66]">Добавьте важные детали: вырез, застёжки, подкладку, длину, карманы, отделку или ограничения по ткани.</p>
                </div>
                <div class="grid grid-cols-2 gap-4 max-[760px]:grid-cols-1">
                    <input type="hidden" name="parameters[2][key]" value="Детали изделия">
                    <label class="field-label">
                        <span>Ключевые детали</span>
                        <input class="field-control" name="parameters[2][value]" placeholder="Например: потайная молния, подкладка, карманы" value="{{ old('parameters.2.value') }}">
                    </label>
                    <input type="hidden" name="parameters[3][key]" value="Нежелательные элементы">
                    <label class="field-label">
                        <span>Чего избегать</span>
                        <input class="field-control" name="parameters[3][value]" placeholder="Например: без глубокого выреза" value="{{ old('parameters.3.value') }}">
                    </label>
                </div>
                <label class="field-label mt-4">
                    <span>Референсы</span>
                    <input class="file-control @error('reference_images') field-control-error @enderror @error('reference_images.*') field-control-error @enderror" name="reference_images[]" type="file" accept=".jpg,.jpeg,.png,.webp" multiple data-preview-input>
                    <span class="field-help">До 5 изображений: фасон, ткань, детали, посадка.</span>
                    @error('reference_images')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                    @error('reference_images.*')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </label>
                <div class="mb-5 mt-3 flex flex-wrap gap-2.5 [&>span]:rounded-full [&>span]:border [&>span]:border-[#e3d4da] [&>span]:bg-[#fffdfb] [&>span]:px-3 [&>span]:py-2 [&>span]:text-sm [&>span]:font-bold [&>span]:text-[#6f5b66]" data-preview-list></div>
                <label class="field-label">
                    <span>Комментарий для ателье</span>
                    <textarea class="field-control resize-y @error('customer_comment') field-control-error @enderror" name="customer_comment" rows="5" placeholder="Опишите задачу своими словами: что важно в образе, посадке, ткани или сроке.">{{ old('customer_comment') }}</textarea>
                    @error('customer_comment')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </label>
            </section>
        </div>

        <aside class="sticky top-24 grid gap-4 rounded-lg border border-[#3d1028] bg-[#3d1028] p-6 text-white shadow-2xl shadow-[#5a1839]/25 max-[920px]:static">
            <span class="text-sm font-bold text-white/70">Предварительная стоимость</span>
            <strong class="atelier-serif text-5xl leading-none" data-estimate>0 ₽</strong>
            <small class="leading-6 text-white/72">Оценка пересчитывается на сервере при отправке. Финальная цена зависит от деталей, ткани и объёма ручной работы.</small>
            <button class="btn btn-accent min-h-12" type="submit">Отправить бриф</button>
        </aside>
    </form>
</x-layouts.app>
