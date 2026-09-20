<?php

declare(strict_types=1);

namespace Pagelyne\Media\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Pagelyne\Media\Services\MediaService;

class MediaController
{
    public function __construct(
        protected MediaService $mediaService
    ) {
    }

    /**
     * Display the media library.
     */
    public function index(Request $request): View
    {
        $media = $this->mediaService->paginate(
            page: (int) $request->input('page', 1),
            perPage: (int) $request->input('per_page', 24),
            search: $request->input('search'),
            type: $request->input('type'),
        );

        return view('media::index', [
            'media' => $media,
        ]);
    }

    /**
     * Show the media upload page.
     */
    public function create(): View
    {
        return view('media::create');
    }

    /**
     * Upload media files.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $files = $request->file('files', []);

        $media = $this->mediaService->upload($files);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Media uploaded successfully.',
                'data' => $media,
            ], 201);
        }

        return redirect()
            ->route('media.index')
            ->with('success', 'Media uploaded successfully.');
    }

    /**
     * Display a media item.
     */
    public function show(int|string $media): View|JsonResponse
    {
        $media = $this->mediaService->findOrFail($media);

        if (request()->expectsJson()) {
            return response()->json([
                'data' => $media,
            ]);
        }

        return view('media::show', [
            'media' => $media,
        ]);
    }

    /**
     * Update media information.
     */
    public function update(
        Request $request,
        int|string $media
    ): JsonResponse|RedirectResponse {
        $media = $this->mediaService->update(
            $media,
            $request->validated ?? $request->all()
        );

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Media updated successfully.',
                'data' => $media,
            ]);
        }

        return redirect()
            ->route('media.show', $media)
            ->with('success', 'Media updated successfully.');
    }

    /**
     * Delete a media item.
     */
    public function destroy(int|string $media): JsonResponse|RedirectResponse
    {
        $this->mediaService->delete($media);

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Media deleted successfully.',
            ]);
        }

        return redirect()
            ->route('media.index')
            ->with('success', 'Media deleted successfully.');
    }
}