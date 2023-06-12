<?php

namespace App\Tables\RowActions;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Okipa\LaravelTable\Abstracts\AbstractRowAction;

class DestroyAction extends AbstractRowAction {
	private $route;
	public function __construct(public string $showUrl) {
		$this->route = $showUrl;
	}

	protected function identifier(): string {
		return 'destroy';
	}

	protected function class(Model $model): array {
		return ['text-danger'];
	}

	protected function icon(Model $model): string {
		return config('laravel-table.icon.destroy');
	}

	protected function title(Model $model): string {
		return 'Destroy';
	}

	protected function defaultConfirmationQuestion(Model $model): string|null {
		return null;
	}

	protected function defaultFeedbackMessage(Model $model): string|null {
		return null;
	}

	public function action(Model $model, Component $livewire) {
        // Redirect to the 'orders.destroy' route
        return redirect()->route('orders.destroy', $model->id);
	}
}