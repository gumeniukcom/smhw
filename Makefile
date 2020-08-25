IMAGE = gumeniukcom/smhw
TAG   = 1.0.0
.DEFAULT_GOAL := build
run:
	docker run \
	 -e API_ADDR="$(API_ADDR)" \
	 -e CLIENT_ID="$(CLIENT_ID)" \
	 -e USER_NAME="$(USER_NAME)" \
	 -e USER_EMAIL="$(USER_EMAIL)" \
	 $(IMAGE):latest

build:
	docker build -t $(IMAGE) .

release:
	docker tag $(IMAGE):latest $(IMAGE):$(TAG)
	docker push $(IMAGE):latest
	docker push $(IMAGE):$(TAG)

.PHONY: build
