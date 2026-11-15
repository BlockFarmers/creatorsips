<?php

namespace Azuriom\Plugin\CreatorsIps\Http\Requests;

use Azuriom\Plugin\CreatorsIps\Models\CreatorIp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatorIpRequest extends FormRequest
{
    private const HOSTNAME_PATTERN = '/^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z]{2,63}$/';

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'hostname' => CreatorIp::normalizeHostname($this->input('hostname')),
            'creator' => trim((string) $this->input('creator')),
        ]);
    }

    public function rules(): array
    {
        $creatorIp = $this->route('creatorIp');

        return [
            'hostname' => [
                'required',
                'string',
                'max:253',
                'regex:'.self::HOSTNAME_PATTERN,
                Rule::unique('creatorsips_ips', 'hostname')->ignore($creatorIp?->id),
            ],
            'creator' => ['required', 'string', 'max:32'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'hostname' => trans('creatorsips::admin.fields.hostname'),
            'creator' => trans('creatorsips::admin.fields.creator'),
            'description' => trans('creatorsips::admin.fields.description'),
        ];
    }

    public function toModelAttributes(): array
    {
        $creatorName = $this->input('creator');
        $user = CreatorIp::findUserByName($creatorName);

        return [
            'hostname' => $this->input('hostname'),
            'description' => $this->input('description'),
            'is_enabled' => $this->boolean('is_enabled'),
            'user_id' => $user?->id,
            'minecraft_name' => $user?->name ?? $creatorName,
        ];
    }
}
