IMAGE = gumeniukcom/smhw
TAG   = 1.0.0
.DEFAULT_GOAL := build
run:
	docker run $(IMAGE):latest

build:
	docker build -t $(IMAGE) .

release:
	docker tag $(IMAGE):latest $(IMAGE):$(TAG)
	docker push $(IMAGE):latest
	docker push $(IMAGE):$(TAG)

.PHONY: build
