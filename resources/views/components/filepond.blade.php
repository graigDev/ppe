@props(['server', 'size', 'max'])

<div
    x-data

    x-init="() => {

        FilePond.registerPlugin(FilePondPluginFileValidateSize)
        const pond = FilePond.create($refs.file)

        pond.setOptions({
            allowRevert: false,
            //instantUpload: false,
            dropValidation: true, // Files are validated before they are dropped
            labelIdle: 'Glisser-déposer vos fichiers ou <span class=\'filepond--label-action\'>selectionner</span>',
            labelFileProcessing: 'Téléchargement',
            labelTapToCancel: 'Appuyez pour annuler',
            labelFileProcessingComplete: 'Téléchargement terminé',
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort) => {
                    let form = new FormData()
                    form.append(fieldName, file, file.name)

                    const CancelToken = window.axios.CancelToken
                    const source = CancelToken.source()

                    window.axios({
                        method: 'post',
                        url: '{{@$server ?: ''}}',
                        data: form,
                        cancelToken: source.token,
                        onUploadProgress: (e) => {
                            progress(e.lengthComputable, e.loaded, e.total)
                        }
                    })
                    .then(() => {
                        load(`${file.name}`)
                    })
                    .catch((thrown) => {
                        if(axios.isCancel(thrown))
                        {
                            //
                        }else{
                            //
                        }
                    })

                    return {
                        abort: () => {
                            source.cancel('Operation annulee');
                        }
                    }
                }
            },

            onprocessfile: (error, file) => {
                if(error){
                    return
                }
                //pond.removeFile(file)
            },

            onaddfile: (error, file) => {
                if(error){
                    return
                }
            },

            onprocessfiles: (error, files) => {
                //  Refresh page
                window.location.reload()
            },
        })
    }"

    x-cloak
>
    <div class="mb-2">
        <span class="text-gray-500 text-sm">
            Taille max par fichier {{ @$size ?: '1MB' }}, {{ @$max ?: '1' }} {{ Str::plural('fichier', @$max ?: 1) }} max.
        </span>
    </div>
    <div>
        <input type="file" x-ref="file" multiple name="file" data-max-file-size="{{ @$size ?: '200MB' }}" data-max-files="{{ @$max ?: '30' }}" />
    </div>
</div>

@push('styles')
    @once
        <link href="{{ asset('filepond/filepond.min.css') }}" rel="stylesheet">
    @endonce
@endpush

@push('scripts')
    @once
        <script src="{{ asset('filepond/filepond-validate.min.js') }}"></script>
        <script src="{{ asset('filepond/filepond.min.js') }}"></script>
    @endonce
@endpush
