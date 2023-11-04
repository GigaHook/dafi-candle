<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email'    => ['nullable', 'required_without:tel', 'string', 'email'],
            'tel'      => ['nullable', 'required_without:email', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:18', 'max:18'],
            'password' => ['required', 'string', 'max:20', 'min:6'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $auth = Auth::attempt($this->only([
            $this->tel ? 'tel' : 'email',
            'password',
        ]));

        if (!$auth) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'password' => $this->tel 
                    ? 'Неверный телефон или пароль' 
                    : 'Неверная почта или пароль',
            ]);
        }
        
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 7)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'password' => 'Слишко много попыток входа. Повторите попытку позже.'
            //'email' => trans('auth.throttle', [
            //    'seconds' => $seconds,
            //    'minutes' => ceil($seconds / 60),
            //]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input($this->tel ? 'tel' : 'email')).'|'.$this->ip());
    }
}
